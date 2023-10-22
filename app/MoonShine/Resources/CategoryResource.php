<?php

namespace App\MoonShine\Resources;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

use MoonShine\Decorations\Flex;
use MoonShine\Fields\Date;
use MoonShine\Fields\SwitchBoolean;
use MoonShine\Fields\Text;
use MoonShine\Fields\Textarea;
use MoonShine\FormComponents\ChangeLogFormComponent;
use MoonShine\Resources\Resource;
use MoonShine\Fields\ID;
use MoonShine\Actions\FiltersAction;

class CategoryResource extends Resource
{
    public static string $model = Category::class;

    public static string $title = 'Категории';
    public static array $activeActions = ['create', 'show', 'edit', 'delete'];
    public string $titleField = 'title';
    protected bool $showInModal = true;

    public function fields(): array
    {
        return [
            SwitchBoolean::make('Опубл.', 'active')->autoUpdate(false),
            Text::make('Title', 'title')
                ->sortable()
                ->required(),
            Text::make('url')->required(),
            Text::make('preview_alt')
                ->hideOnIndex(),
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

    public function components(): array
    {
        return [
            ChangeLogFormComponent::make('Change log'),
        ];
    }
}
