<?php

declare(strict_types=1);

namespace App\Actions\ContentBlock;

use App\Models\ContentBlock;
use App\Models\Image;
use App\Services\ImageService;

class ContentBlockCreateOrUpdateAction
{
    public function __invoke($data): void
    {
        $postId = $data['post_id'];
        unset($data['post_id']);
        if (!empty($data['content_block_images'])) {
            foreach ($data['content_block_images'] as $imageFile) {
                $image = new Image();

                $image->name = $data['name'];
                $image->alt = $data['name'];

                $image->save();

                $slug = str_slug($image->name . '-' . $image->id);

                ImageService::generateThumbnails($imageFile->path(), $slug);

                $image->path = $slug . '.jpg';
                $image->slug = $slug . '.jpg';
                $image->save();
                $image->posts()->attach($postId);
                if (!empty($data['id'])) {
                    $image->contentBlocks()->attach($data['id']);
                }
            }
        }
        unset($data['content_block_images']);

        $contentBlock = ContentBlock::updateOrCreate(['id' => $data['id']], $data);

        $contentBlock->posts()->syncWithoutDetaching($postId);
    }
}
