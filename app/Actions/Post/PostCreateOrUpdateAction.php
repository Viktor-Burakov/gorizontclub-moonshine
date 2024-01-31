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
    public function __invoke($data)
    {
        $data['slug'] = str_slug($data['slug']);
        unset($data['preview']);

        $categories = array();
        if (isset($data['categories'])) {
            $categories = collect($data['categories'])->pluck('id');
            unset($data['categories']);
        }

        $contentBlocksSync = array();
        $ContentBlocksArrayIndex = array();
        if (isset($data['content_blocks'])) {
            $contentBlocksToApsert = array();
            $updatedAt = Carbon::now();

            foreach ($data['content_blocks'] as $index => $contentBlock) {
                if (!isset($contentBlock['id'])) {
                    $contentBlock['id'] = null;
                }

                unset($contentBlock['images']);
                $contentBlock['updated_at'] = $updatedAt;

                $contentBlocksToApsert[] = $contentBlock;
                $ContentBlocksArrayIndex[$contentBlock['name']] = $index;
            }

            ContentBlock::upsert(
                $contentBlocksToApsert,
                ['id'],
                ['name', 'title', 'description',]
            );
            $contentBlocksArray = ContentBlock::select('id', 'name')
                ->where('updated_at', $updatedAt)
                ->get();

            foreach ($contentBlocksArray as $cb) {
                $contentBlocksSync[$cb->id] = ['sort' => $ContentBlocksArrayIndex[$cb->name]];
            }

            unset($data['content_blocks']);
        }

        $images = array();
        if (isset($data['images'])) {
            foreach ($data['images'] as $index => $image) {
                if (!is_int($image['id'])) {
                    continue;
                }
                $images[$image['id']] = ['sort' => $index];
            }
            unset($data['images']);
        }

        $post = Post::updateOrCreate(['id' => $data['id']], $data);

        $post->categories()->sync($categories);
        $post->contentBlocks()->sync($contentBlocksSync);
        $post->images()->sync($images);

        return 'Пост id:' . $post->id . ' обновлен!';

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
