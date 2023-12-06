<?php

namespace App\MoonShine\Resources;

use App\Models\Post;
use App\MoonShine\Fields\PostImage;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Flex;
use MoonShine\Decorations\Grid;
use MoonShine\Fields\Date;
use MoonShine\Fields\Image;
use MoonShine\Fields\Relationships\BelongsToMany;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Text;
use MoonShine\Fields\Textarea;
use MoonShine\QueryTags\QueryTag;
use MoonShine\Resources\ModelResource;

class PostResource extends ModelResource
{
    protected string $model = Post::class;

    protected string $title = 'Посты';
    protected int $itemsPerPage = 20;
    protected string $sortColumn = 'date_start';
    protected string $orderType = 'asc';
    protected array $activeActions = ['create', 'show', 'edit', 'delete'];
    protected string $column = 'title';
    protected bool $showInModal = true;

    public function fields(): array
    {
        return [
            Grid::make([
                Column::make([
                    Block::make('SEO', [
                        Text::make('Title', 'title')
                            ->sortable()
                            ->required(),
                        PostImage::make(),
                        Image::make('preview'),
                        Text::make('url')
                            ->required()
                            ->hideOnIndex(),
                        Textarea::make('Description (SEO)', 'description')->hideOnIndex(),
                    ]),
                ])->columnSpan(12),
                Column::make([
                    Block::make('Основное', [
                        Switcher::make('Опубл.', 'active'),

                        Text::make('Заголовок (H1)', 'h1')
                            //  ->hideOnIndex()
                            ->required(),
                        Textarea::make('Анонс', 'preview_text')->hideOnIndex(),
                        Text::make('preview_alt')
                            ->hideOnIndex(),
                        Flex::make([
                            Date::make('Начало', 'date_start')
                                ->withTime()
                                ->hideOnIndex(),
                            Date::make('Окончание', 'date_end')
                                ->withTime()
                                ->hideOnIndex(),
                        ]),
                        Text::make('Даты', 'date_start', function (Post $post) {
                            return
                                Carbon::parse($post->date_start)->translatedFormat('d.m.y l H:i') . '<br>' .
                                Carbon::parse($post->date_end)->translatedFormat('d.m.y l H:i');
                        })
                            ->sortable()
                            ->hideOnForm(),
                        BelongsToMany::make('Разделы', 'categories')
                            ->selectMode()
                            ->inLine(separator: ' ', badge: true),
                    ]),
                ])->columnSpan(12),
            ]),
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }

    public function queryTags(): array
    {
        return [
            QueryTag::make(
                'Опубликованы',
                fn(Builder $query) => $query->where('active', 1)
            )->icon('heroicons.eye'),
            QueryTag::make(
                'Черновик',
                fn(Builder $query) => $query->where('active', 0)
            )->icon('heroicons.pencil-square'),

        ];
    }

    public function search(): array
    {
        return ['id'];
    }

    public function filters(): array
    {
        return [
            Text::make('date_start'),
            Text::make('date_end'),
            BelongsToMany::make('Categories')
        ];
    }


    public function components(): array
    {
        return [
         //   ChangeLogFormComponent::make('Change log'),
        ];
    }
}
