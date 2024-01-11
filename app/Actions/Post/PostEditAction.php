<?php

declare(strict_types=1);

namespace App\Actions\Post;

use App\Models\Post;

class PostEditAction
{
    public function handle(int $postId): Post
    {
        $post = Post::with(['categories:id,title', 'contentBlocks.images', 'images'])
            ->where('id', '=', $postId)
            ->get()
            ->first();

        return $post;
    }
}
