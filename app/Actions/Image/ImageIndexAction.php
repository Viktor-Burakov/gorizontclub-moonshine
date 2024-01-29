<?php

declare(strict_types=1);

namespace App\Actions\Image;

use App\Models\ContentBlock;
use App\Models\Image;
use Illuminate\Database\Eloquent\Collection;

class ImageIndexAction
{
    public function __invoke(): Collection
    {
        return Image::all(['id', 'name', 'alt', 'path', 'slug'])->keyBy('id');
    }
}
