<?php

declare(strict_types=1);

namespace App\Actions\Post;

use App\Actions\ContentBlock\ContentBlockCreateOrUpdateAction;
use App\Actions\Image\ImageUpsertAndSyncAction;
use App\Models\Post;

class PostCreateOrUpdateAction
{
    public function __invoke($data)
    {
        /// todo делать для КБ createOrUpdate , а для Images ввиде сервиса


        $data['slug'] = str_slug($data['slug']);
        unset($data['preview']);

        $categoriesSync = array();
        if (isset($data['categories'])) {
            $categoriesSync = collect($data['categories'])->pluck('id');
            unset($data['categories']);
        }

        $contentBlocksSync = array();
        if (isset($data['content_blocks'])) {
            $contentBlocksSync = (new ContentBlockCreateOrUpdateAction)($data['content_blocks']);
            unset($data['content_blocks']);
        }

        $imagesSync = array();

        if (isset($data['images'])) {
            $imagesSync = (new ImageUpsertAndSyncAction())($data['images']);
            unset($data['images']);
        }

        $post = Post::updateOrCreate(['id' => $data['id']], $data);

        $post->categories()->sync($categoriesSync);
        $post->contentBlocks()->sync($contentBlocksSync);
        $post->images()->sync($imagesSync);

        return 'Пост id:' . $post->id . ' обновлен!';
    }
}
