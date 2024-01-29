<?php

declare(strict_types=1);

namespace App\Actions\ContentBlock;

use App\Models\ContentBlock;
use Illuminate\Database\Eloquent\Collection;

class ContentBlockIndexAction
{
    public function __invoke(): Collection
    {
        return ContentBlock::all(['id', 'name'])->keyBy('id');
    }
}
