<?php

declare(strict_types=1);

namespace App\MoonShine\Forms;


use App\Enums\ImageEnum;
use Illuminate\Support\Facades\Storage;
use MoonShine\Components\FormBuilder;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Grid;
use MoonShine\Fields\Hidden;
use MoonShine\Fields\Image;
use MoonShine\Fields\Preview;
use MoonShine\Fields\Text;

class ImageForm
{
    public static function make($imageData = []): FormBuilder
    {
        return FormBuilder::make(route('image.store'))
            ->fields([
                Hidden::make('post_id'),
                Hidden::make('content_block_id'),
                Hidden::make('content_block_title'),
                Grid::make([
                    Column::make([
                        Preview::make('Preview', 'slug', function ($item) {
                            return '<img alt="" src="' . Storage::url(
                                    ImageEnum::CONTAINER['dir'] . $item['slug']
                                ) . '" class="max-h-64">'
                                . '<small>' . $item['slug'] . '</small>';
                        }),
                    ])
                        ->columnSpan(4),

                    Column::make([
                        Text::make('name')
                            ->required(),
                        Text::make('alt'),
                        Text::make('slug'),
                        Image::make('images')
                            ->allowedExtensions(['jpg', 'png', 'gif', 'heic', 'webp'])
                    ])
                        ->columnSpan(8)
                ]),
            ])
            ->name('image-form')
            ->fill($imageData)
            ->async(asyncEvents: 'table-updated-main-table')
            ->submit('Сохранить', ['class' => 'btn btn-primary w-full']);
    }
}
