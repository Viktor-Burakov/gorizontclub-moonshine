<?php

declare(strict_types=1);

namespace App\Actions\Post;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;


class PostIndexAction
{
    public function __invoke(): Collection
    {
        return Post::with(['categories:id,title'])->get();
    }
}
