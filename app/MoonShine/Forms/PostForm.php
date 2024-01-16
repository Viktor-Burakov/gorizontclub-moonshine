<?php

declare(strict_types=1);

namespace App\MoonShine\Forms;

use App\Enums\PostEnum;
use App\Models\Post;
use App\MoonShine\Fields\ContentBlocks;
use MoonShine\Components\FormBuilder;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Grid;
use MoonShine\Fields\DateRange;
use MoonShine\Fields\ID;
use MoonShine\Fields\Image;
use MoonShine\Fields\Relationships\BelongsToMany;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Text;
use MoonShine\Fields\Textarea;
use MoonShine\TypeCasts\ModelCast;

class PostForm
{
    public static function make(array $postData = []): FormBuilder
    {
        return FormBuilder::make(route('post.store'))
            ->fields(fn() => [
                ID::make('id'),
                Grid::make([
                    Column::make([
                        Block::make('SEO', [
                            Text::make('Title', 'title')
                                ->required(),
                            Text::make('Slug')
                                ->required(),
                            Text::make('Preview Alt', 'preview_alt'),
                            Textarea::make('Description (SEO)', 'description'),
                        ]),
                    ])->columnSpan(12),
                    Column::make([
                        Block::make('Основное', [
                            Switcher::make('Опубл.', 'active'),
                            Image::make('Preview')
                                ->allowedExtensions(['jpg', 'png'])
                                ->dir(PostEnum::POST_PREVIEW['dir']),

                            Text::make('Заголовок (H1)', 'h1')
                                ->required(),
                            Textarea::make('Анонс', 'preview_text'),
                            DateRange::make('Даты')
                                ->fromTo('date_start', 'date_end')
                                ->withTime(),
                            BelongsToMany::make('Разделы', 'categories')
                                ->selectMode(),
                            ContentBlocks::make('content_blocks', 'contentBlocks')
                            //     ->selectMode()
                            // todo     PostImage::make(),
                        ]),
                    ])->columnSpan(12),
                ])

            ])
            ->name('post-form')
            ->async(asyncEvents: 'fragment-updated-post-form')
            ->fillCast($postData, ModelCast::make(Post::class))
            ->submit('Сохранить пост', ['class' => 'btn btn-primary w-full']);
    }


}
