<?php

declare(strict_types=1);

namespace App\Actions\Category;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;


class CategoryIndexAction
{
    public function __invoke(): Collection
    {
        return Category::all(['id', 'title'])->keyBy('id');
    }
}
