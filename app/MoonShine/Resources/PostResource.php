<?php

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use Carbon\Carbon;

use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Flex;
use MoonShine\Decorations\Grid;
use MoonShine\Fields\BelongsToMany;
use MoonShine\Fields\Date;
use MoonShine\Fields\NoInput;
use MoonShine\Fields\StackFields;
use MoonShine\Fields\SwitchBoolean;
use MoonShine\Fields\Text;
use MoonShine\Fields\Textarea;
use MoonShine\Fields\Url;
use MoonShine\Filters\BelongsToManyFilter;
use MoonShine\Filters\DateFilter;
use MoonShine\Filters\DateRangeFilter;
use MoonShine\Filters\SelectFilter;
use MoonShine\Filters\SwitchBooleanFilter;
use MoonShine\QueryTags\QueryTag;
use MoonShine\Resources\Resource;
use MoonShine\Fields\ID;
use MoonShine\Actions\FiltersAction;
use MoonShine\FormComponents\ChangeLogFormComponent;
use Symfony\Component\Finder\Iterator\DateRangeFilterIterator;
use Illuminate\Contracts\Database\Eloquent\Builder;

class PostResource extends Resource
{
    public static string $model = Post::class;

    public static string $title = 'Посты';
    public static int $itemsPerPage = 20;
    public static string $orderField = 'date_start';
    public static string $orderType = 'asc';
    public static array $activeActions = ['create', 'show', 'edit', 'delete'];
    public string $titleField = 'title';
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
                        Text::make('url')
                            ->required()
                            ->hideOnIndex(),
                        Textarea::make('Description (SEO)', 'description')->hideOnIndex(),
                    ]),
                ])->columnSpan(12),
                Column::make([
                    Block::make('Основное', [
                        SwitchBoolean::make('Опубл.', 'active')->autoUpdate(false),

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
                            ->select()
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
            )->icon('show'),
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
            DateRangeFilter::make('date_start'),
            DateRangeFilter::make('date_end'),
            BelongsToManyFilter::make('Categories')
        ];
    }

    public function actions(): array
    {
        return [
            FiltersAction::make(trans('moonshine::ui.filters')),
        ];
    }

    public function components(): array
    {
        return [
            ChangeLogFormComponent::make('Change log'),
        ];
    }
}
