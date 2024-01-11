<?php

declare(strict_types=1);

namespace App\MoonShine\Forms;

use App\MoonShine\Fields\PostImage;
use MoonShine\Components\FormBuilder;
use MoonShine\Decorations\Block;
use MoonShine\Fields\Hidden;
use MoonShine\Fields\ID;
use MoonShine\Fields\Text;
use MoonShine\Fields\Textarea;

class ContentBlockForm
{
    public static function make(string $postId, array $contentBlockData = []): FormBuilder
    {
        $contentBlockName = (isset($contentBlockData['name'])) ?
            '#' . $contentBlockData['id'] . ' - ' . $contentBlockData['name']
            : 'Добавить блок';

        return FormBuilder::make(route('content-block.store'))
            ->fields([
                Block::make(
                    $contentBlockName,
                    [
                        ID::make('id'),
                        Text::make('name')->required(),
                        Hidden::make('post_id')->default($postId),
                        Text::make('title'),
                        Textarea::make('description'),
                        PostImage::make(),
                    ]
                )
            ])
            ->name('content-block-form')
            ->fill($contentBlockData)
            ->async()
            ->submit('Сохранить блок', ['class' => 'btn btn-primary w-full']);
    }
}
