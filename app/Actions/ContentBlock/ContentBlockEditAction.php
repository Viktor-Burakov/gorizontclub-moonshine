<?php

declare(strict_types=1);

namespace App\Actions\ContentBlock;

use App\Models\ContentBlock;
use App\Models\Image;
use App\Models\Post;
use Illuminate\Support\Collection;

class ContentBlockEditAction
{
    public function __invoke(int $id): ContentBlock
    {
        return ContentBlock::with(['images:id'])
            ->where('id', '=', $id)
            ->get()
            ->first();
    }
}
