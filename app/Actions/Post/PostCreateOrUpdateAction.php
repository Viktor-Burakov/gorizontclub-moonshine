<?php

declare(strict_types=1);

namespace App\Actions\Post;

use App\Enums\PostEnum;
use App\Models\Post;
use App\Services\ImageService;

class PostCreateOrUpdateAction
{
    public function handle($data): void
    {
        $data['slug'] = str_slug($data['slug']);

        $categories = array();
        if (isset($data['categories'])) {
            $categories = $data['categories'];
            unset($data['categories']);
        }

        if (isset($data['preview'])) {
            $preview = $data['preview'];
            $data['preview'] = $data['slug'] . '.jpg';
        }

        $post = Post::updateOrCreate(['id' => $data['id']], $data);

        $post->categories()->sync($categories);

        if (!empty($preview)) {
            $pathPreview = storage_path('app/public/' . PostEnum::POST_PREVIEW['dir'] . $post->preview);

            $thumbnail = new ImageService($preview);
            $thumbnail->resize(PostEnum::POST_PREVIEW['width']);

            $thumbnail->saveToJpgAndWebP($pathPreview);
        }
    }
}
