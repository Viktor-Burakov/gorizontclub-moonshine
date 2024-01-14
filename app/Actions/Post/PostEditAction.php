<?php

declare(strict_types=1);

namespace App\Actions\Post;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Support\Collection;

class PostEditAction
{
    public function handle(int $postId): Collection
    {
        $post = Post::with(['categories:id,title', 'contentBlocks.images:id', 'images:id'])
            ->where('id', '=', $postId)
            ->get()
            ->first();

        $imagesId = $post->images->pluck('id');

        foreach ($post->contentBlocks as $contentBlock) {
            $imagesId = $imagesId->merge($contentBlock->images->pluck('id'));
        }

        $imageData = Image::findMany($imagesId->unique())
            ->keyBy('id');

        return collect($post)->put('image_models', $imageData);
    }
}
