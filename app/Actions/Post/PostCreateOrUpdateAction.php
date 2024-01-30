<?php

declare(strict_types=1);

namespace App\Actions\Post;

use App\Enums\PostEnum;
use App\Models\ContentBlock;
use App\Models\Post;
use App\Services\ImageService;
use Illuminate\Support\Carbon;

class PostCreateOrUpdateAction
{
    public function __invoke($data): void
    {
        $data['slug'] = str_slug($data['slug']);
        unset($data['preview']);

        $categories = array();
        if (isset($data['categories'])) {
            $categories = collect($data['categories'])->pluck('id');
            unset($data['categories']);
        }

        $contentBlocksSync = array();
        if (isset($data['content_blocks'])) {
            $contentBlocks = array();
            $updatedAt = Carbon::now();

            foreach ($data['content_blocks'] as $contentBlock) {
                if (isset($contentBlock['id'])) {
                    $contentBlocksSync[] = $contentBlock['id'];
                } else {
                    $contentBlock['id'] = null;
                }
                unset($contentBlock['images']);
                $contentBlock['updated_at'] = $updatedAt;
                $contentBlocks[] = $contentBlock;
            }

            ContentBlock::upsert(
                $contentBlocks,
                ['id'],
                ['name', 'title', 'description',]
            );
            $contentBlocksSync = ContentBlock::select('id')
                ->where('updated_at', $updatedAt)
                ->get()
                ->pluck('id')
                ->toArray();

            unset($data['content_blocks']);
        }

        $images = array();
        if (isset($data['images'])) {
            $images = collect($data['images'])->pluck('id');
            unset($data['images']);
        }

        dump($contentBlocksSync);
        dump($images);


        $post = Post::updateOrCreate(['id' => $data['id']], $data);

        $post->categories()->sync($categories);
        $post->contentBlocks()->sync($contentBlocksSync);
        $post->images()->sync($images);


//        if (!empty($preview)) {
//            $pathPreview = storage_path('app/public/' . PostEnum::POST_PREVIEW['dir'] . $post->preview);
//
//            $thumbnail = new ImageService($preview);
//            $thumbnail->resize(PostEnum::POST_PREVIEW['width']);
//
//            $thumbnail->saveToJpgAndWebP($pathPreview);
//        }
    }
}
