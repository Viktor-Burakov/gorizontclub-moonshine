<?php

declare(strict_types=1);

namespace App\Actions\Post;

use App\Models\ContentBlock;
use App\Models\Image;
use App\Models\Post;
use App\Services\PostContentService;

class PostCreateOrUpdateAction
{
    public function __invoke($data)
    {
        $data['slug'] = str_slug($data['slug']);
        unset($data['preview']);

        $categoriesSync = array();
        if (isset($data['categories'])) {
            $categoriesSync = collect($data['categories'])->pluck('id');
            unset($data['categories']);
        }

        $contentBlocksSync = array();
        if (isset($data['content_blocks'])) {
            $contentBlocks = new PostContentService(
                $data['content_blocks'],
                new ContentBlock,
                ['name', 'title', 'description']
            );
            $contentBlocksSync = $contentBlocks->getSync();

            unset($data['content_blocks']);
        }

        $imagesSync = array();

        if (isset($data['images'])) {
            $images = new PostContentService(
                $data['images'],
                new Image,
                []
            );
            $imagesSync = $images->getSync();

            unset($data['images']);
        }

        $post = Post::updateOrCreate(['id' => $data['id']], $data);

        $post->categories()->sync($categoriesSync);
        $post->contentBlocks()->sync($contentBlocksSync);
        $post->images()->sync($imagesSync);

        return 'Пост id:' . $post->id . ' обновлен!';

    }
}
