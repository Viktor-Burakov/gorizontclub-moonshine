<?php

declare(strict_types=1);

namespace App\Actions\Post;

use App\Enums\PostEnum;
use App\Models\Image;
use App\Models\Post;
use App\Services\ImageService;
use App\Services\PostContentService;
use Illuminate\Support\Facades\Storage;
use ReflectionClass;


class PostImagesCreateOrUpdateAction
{
    public function __invoke($data): array
    {
        $message = '';
        $err = false;

        if (isset($data['images'])) {
            $thumbnailsEnums = new ReflectionClass('App\Enums\ImageEnum');

            foreach ($data['images'] as $index => $image) {
                if (isset($image['file'])) {
                    try {
                        $imageDB = Image::select(['id', 'slug'])
                            ->where('name', $image['id'])
                            ->first();

                        $slug = $image['slug'] . '_' . $imageDB->id . '.jpg';

                        foreach ($thumbnailsEnums->getConstants() as $thumbnailOption) {
                            $storePath = storage_path('app/public/' . $thumbnailOption['dir'] . $slug);

                            $thumbnail = new ImageService($image['file']);
                            $thumbnail->resize($thumbnailOption['width']);
                            $thumbnail->saveToJpgAndWebP($storePath);
                        }
                        $imageDB->update([
                            'name' => $image['name'],
                            'alt' => $image['alt'],
                            'slug' => $slug
                        ]);

                        $message .= 'Изображение ' .
                            $image['file']->getClientOriginalName() . ' (' .
                            $slug . ') загружено!' . PHP_EOL . PHP_EOL;
                    } catch (\Throwable $err) {
                        $message .= 'Ошибка загрузки: ' . $image['file']->getClientOriginalName() .
                            $err->getMessage() . PHP_EOL . PHP_EOL .
                            'File: ' . $err->getFile() . PHP_EOL . PHP_EOL .
                            'Line: ' . $err->getLine() . PHP_EOL . PHP_EOL;
                        $err = true;
                    }
                    unset($data['images'][$index]);
                }
            }

            $images = new PostContentService(
                $data['images'],
                new Image,
                ['name', 'alt']
            );
        }

        if (!empty($data['preview'])) {
            try {
                $post = Post::select(['id', 'preview', 'slug'])
                    ->where('preview', $data['oldPreview'])
                    ->first();


                $pathPreview = storage_path('app/public/' . PostEnum::POST_PREVIEW['dir'] . $post->slug);

                Storage::delete('public/' . PostEnum::POST_PREVIEW['dir'] . $data['oldPreview']);

                $thumbnail = new ImageService($data['preview']);
                $thumbnail->resize(PostEnum::POST_PREVIEW['width']);
                $thumbnail->saveToJpgAndWebP($pathPreview);

                $preview = $post->slug . '.jpg';
                $post->update(['preview' => $preview]);

                $message .= 'Превью обновлено!' . PHP_EOL . PHP_EOL;
            } catch (\Throwable $err) {
                $message .= 'Ошибка загрузки превью: ' .
                    $err->getMessage() . PHP_EOL . PHP_EOL .
                    'File: ' . $err->getFile() . PHP_EOL . PHP_EOL .
                    'Line: ' . $err->getLine() . PHP_EOL . PHP_EOL;
                $err = true;
            }
        }

        return ['message' => $message, 'err' => $err];
    }
}
