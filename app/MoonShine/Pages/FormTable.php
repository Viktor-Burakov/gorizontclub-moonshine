<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use App\Models\ContentBlock;
use App\MoonShine\Forms\ContentBlockForm;
use App\MoonShine\Forms\ImageForm;
use MoonShine\Components\TableBuilder;
use MoonShine\Decorations\Block;
use MoonShine\Fields\Text;
use MoonShine\Fields\TinyMce;
use MoonShine\Pages\Page;

class FormTable extends Page
{
    public function breadcrumbs(): array
    {
        return [
            '#' => $this->title()
        ];
    }

    public function title(): string
    {
        return $this->title ?: 'FormTable';
    }

    public function components(): array
    {
        return [
            Block::make([
                ContentBlockForm::render('1'),
                ImageForm::render('1', '1', 'contentBlockName')
            ]),
            TableBuilder::make()
                ->fields(fn() => [
                    Text::make('name')->badge('yellow'),

                    Text::make('title')->badge('gray'),
                    TinyMce::make('description')->badge('gray'),

                ])
                ->items($this->getContentBlock())
                ->name('main-table')
                ->vertical()
                //   ->editable()
                ->async(),

        ];
    }

    private function getContentBlock(): array
    {
        $postId = 1;
        return ContentBlock::with('images')
            ->whereHas('posts', function ($query) use ($postId) {
                return $query->where('posts.id', '=', $postId);
            })
            ->get()->toArray();
        return ContentBlock::orderBy('id', 'desc')->get()->toArray();
    }
}
