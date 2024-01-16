<?php

declare(strict_types=1);

namespace App\Actions\Post;

use App\Enums\ImageEnum;
use App\Models\Post;
use App\MoonShine\Forms\ContentBlockForm;
use App\MoonShine\Forms\ImageForm;
use App\MoonShine\Forms\PostForm;
use Illuminate\Support\Facades\Storage;

class PostEditAction1
{
    public function handle(string $postId): array
    {
        $post1 = Post::with(['categories:id', 'contentBlocks.images', 'images'])
            ->where('id', '=', $postId)
            ->get()
            ->first();

        $post = $post1->toArray();

        foreach ($post['categories'] as $key => $category) {
            $post['categories'][$key] = $category['id'];
        }

        $contentBlocks = array();
        foreach ($post['content_blocks'] as $contentBlock) {
            $contentBlocks[$contentBlock['id']]['form'] = ContentBlockForm::make($postId, $contentBlock);
            foreach ($contentBlock['images'] as $image) {
                $image['post_id'] = $postId;
                $image['content_block_id'] = $contentBlock['id'];
                $image['content_block_title'] = $contentBlock['title'];
                $contentBlocks[$contentBlock['id']]['images'][] = [
                    'preview' => Storage::url(
                        ImageEnum::CONTAINER['dir'] . $image['slug']
                    ),
                    'name' => $image['name'],
                    'form' => ImageForm::make($image)
                ];
            }
        }

        $images = array();
        foreach ($post['images'] as $image) {
            $image['post_id'] = $postId;
            $images[] = ImageForm::make($image);
        }
        $post1 = Post::with(['categories:id', 'contentBlocks.images', 'images'])
            ->where('id', '=', $postId)
            ->get()
            ->first();
        return [
            'post' => $post1,
            'form' => PostForm::make($post),
            'contentBlocks' => $contentBlocks,
            'formContentBlock' => ContentBlockForm::make($postId),
            'images' => $images,
        ];
    }
}
