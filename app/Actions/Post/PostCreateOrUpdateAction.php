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

            $contentBlocksSync = (new PostContentUpsert)($data['content_blocks'], new ContentBlock, ['name', 'title', 'description']);

            unset($data['content_blocks']);
        }

        $images = array();
        if (isset($data['images'])) {
            foreach ($data['images'] as $index => $image) {
                if (!is_int($image['id'])) {
                    dump($image['id']);
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
