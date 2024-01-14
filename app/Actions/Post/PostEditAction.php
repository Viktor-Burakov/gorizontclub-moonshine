<?php

declare(strict_types=1);

namespace App\Actions\Post;

use App\Actions\Category\CategoryIndexAction;
use App\Actions\ContentBlock\ContentBlockIndexAction;
use App\Actions\Image\ImageIndexAction;
use App\Models\Post;
use Illuminate\Support\Collection;

class PostEditAction
{
    public function handle(int $postId): Collection
    {
        $data = collect();

        $post = Post::with(['categories:id,title', 'contentBlocks.images:id', 'images:id'])
            ->where('id', '=', $postId)
            ->get()
            ->first();
        $data->put('post', $post);

        $categoriesList = new CategoryIndexAction();
        $data->put('category', $categoriesList->handle());

        $contentBlockList = new ContentBlockIndexAction();
        $data->put('contentBlocks', $contentBlockList->handle());

        $imageModels = new ImageIndexAction();
        $data->put('images', $imageModels->handle());


        return $data;
    }
}
