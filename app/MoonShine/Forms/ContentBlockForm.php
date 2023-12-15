<?php

declare(strict_types=1);

namespace App\MoonShine\Forms;

use App\MoonShine\Fields\PostImage;
use MoonShine\Components\FormBuilder;
use MoonShine\Fields\Hidden;
use MoonShine\Fields\Text;
use MoonShine\Fields\TinyMce;

class ContentBlockForm
{
    public static function render(string $postId): FormBuilder
    {
        return FormBuilder::make(route('content-block.store'))
            ->fields([
                Hidden::make('post_id')->default($postId),
                Text::make('name')->required(),
                Text::make('title'),
                TinyMce::make('description'),
                PostImage::make(),
            ])
            ->name('content-block-form')
            ->async(asyncEvents: 'table-updated-main-table,form-reset-content-block-form');
    }
}
