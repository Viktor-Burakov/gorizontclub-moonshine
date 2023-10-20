<?php

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use Carbon\Carbon;

use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Flex;
use MoonShine\Decorations\Grid;
use MoonShine\Fields\Date;
use MoonShine\Fields\SwitchBoolean;
use MoonShine\Fields\Text;
use MoonShine\Fields\Textarea;
use MoonShine\Fields\Url;
use MoonShine\Resources\Resource;
use MoonShine\Fields\ID;
use MoonShine\Actions\FiltersAction;

class PostResource extends Resource
{
    public static string $model = Post::class;

    public static string $title = 'Посты';
    public static int $itemsPerPage = 20;
    public static string $orderField = 'date_start';
    public string $titleField = 'title';

    public static array $activeActions = ['create', 'show', 'edit'];

    public function fields(): array
    {
        return [
            Block::make('Основное', [
                SwitchBoolean::make('Опубл.', 'active')->autoUpdate(false),
                Text::make('Title (SEO)', 'title')
                    ->sortable()
                    ->required(),
                Text::make('h1')
                    //  ->hideOnIndex()
                    ->required(),
                Text::make('url')
                    ->required()
                    ->hideOnIndex(),
                Textarea::make('Анонс', 'preview_text')->hideOnIndex(),
                Textarea::make('Description (SEO)', 'description')->hideOnIndex(),
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
            ]),

        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }

    public function search(): array
    {
        return ['id'];
    }

    public function filters(): array
    {
        return [];
    }

    public function actions(): array
    {
        return [
            FiltersAction::make(trans('moonshine::ui.filters')),
        ];
    }
}
