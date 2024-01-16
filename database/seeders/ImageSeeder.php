<?php

namespace Database\Seeders;

use App\Enums\PostEnum;
use App\Models\Image;
use App\Models\Post;
use App\Services\ImageService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use ReflectionClass;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Image::factory(7)
            ->create();

        $dirTestImages = 'public/';
        Storage::deleteDirectory($dirTestImages . 'images_test/');
        Storage::makeDirectory($dirTestImages . 'images_test/');
        Storage::makeDirectory($dirTestImages . PostEnum::POST_PREVIEW['dir']);
        $thumbnailsEnums = new ReflectionClass('App\Enums\ImageEnum');

        foreach ($thumbnailsEnums->getConstants() as $thumbnail) {
            Storage::makeDirectory($dirTestImages . $thumbnail['dir']);
        }

        Image::all()->each(function ($image) use ($dirTestImages, $thumbnailsEnums) {
            $sourceImagePath = storage_path('app/' . $dirTestImages . 'images_test/') . $image->path . '.jpg';

            if (ImageService::createFakeImage(
                $sourceImagePath,
                fake()->numberBetween(800, 3000),
                fake()->numberBetween(800, 2560),
                $image->name
            )) {
                foreach ($thumbnailsEnums->getConstants() as $thumbnailOption) {
                    $path = storage_path('app/' . $dirTestImages . $thumbnailOption['dir'] . $image->path);
                    $thumbnail = new ImageService($sourceImagePath);
                    $thumbnail->resize($thumbnailOption['width']);
                    $thumbnail->saveToJpgAndWebP($path);
                }
            };
        });

        Post::all()->each(function ($post) use ($dirTestImages) {
            $sourceImagePath = storage_path('app/' . $dirTestImages . 'images_test/') . $post->slug . '.jpg';

            if (ImageService::createFakeImage($sourceImagePath, 1080, 1080, $post->title)) {
                $path = storage_path('app/' . $dirTestImages . PostEnum::POST_PREVIEW['dir'] . $post->slug);
                $thumbnail = new ImageService($sourceImagePath);
                $thumbnail->resize(PostEnum::POST_PREVIEW['width']);
                $thumbnail->saveToJpgAndWebP($path);
            };
        });
    }
}
