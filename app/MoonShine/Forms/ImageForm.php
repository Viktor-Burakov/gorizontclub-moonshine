<?php

declare(strict_types=1);

namespace App\MoonShine\Forms;

use MoonShine\Components\FormBuilder;
use MoonShine\Fields\Hidden;
use MoonShine\Fields\Image;

class ImageForm
{
    public static function render(string $postId, string $contentBlockId, string $contentBlockTitle,): FormBuilder
    {
        return FormBuilder::make(route('image.store'))
            ->fields([
                Hidden::make('post_id')->default($postId),
                Hidden::make('content_block_id')->default($contentBlockId),
                Hidden::make('content_block_title')->default($contentBlockTitle),
                Image::make('images')
                    ->multiple()
                    ->required()
                    ->allowedExtensions(['jpg', 'png', 'gif', 'heic', 'webp'])


            ])
            ->name('image-form')
            //    ->async(asyncEvents: 'table-updated-main-table,form-reset-image-form');
            ->async(asyncEvents: 'table-updated-main-table');
    }
}
