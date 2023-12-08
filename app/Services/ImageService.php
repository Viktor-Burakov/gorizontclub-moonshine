<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImageService
{
    private mixed $image;

    public function __construct(mixed $image)
    {
        $manager = new ImageManager(new Driver());
        $this->image = $manager->read($image);
    }

    public function resize(?int $width = null, ?int $height = null): void
    {
        $this->image->scaleDown($width, $height);
    }

    public function saveToJpgAndWebP(string $filePath): string
    {
        $this->saveToJpg($filePath);
       // todo $this->saveToWebP($filePath);
        return $filePath;
    }

    public function saveToJpg(string $filePath): string
    {
        $path = $filePath . '.jpg';
        $this->image->toJpeg()->save($path);
        return $path;
    }

    public function saveToWebP(string $filePath): string
    {
        $path = $filePath . '.webp';
        $this->image->toWebp(85)->save($path);
        return $path;
    }

    public static function createFakeImage(string $path, int $x, int $y, string $text = ''): bool
    {
        $jpg_image = @imagecreate($x, $y);

        imagecolorallocate(
            $jpg_image,
            fake()->numberBetween(0, 126),
            fake()->numberBetween(0, 126),
            fake()->numberBetween(0, 126)
        );

        if ($text) {
            imagettftext(
                $jpg_image,
                $x / 30,
                0,
                $x / 10,
                $y / 2,
                imagecolorallocate($jpg_image, 255, 255, 255),
                Storage::path('public/arial.ttf'),
                $text
            );
        }
        $res = imagejpeg($jpg_image, $path);
        imagedestroy($jpg_image);
        return $res;
    }
}
