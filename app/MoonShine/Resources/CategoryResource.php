<?php

namespace App\MoonShine\Resources;

use App\Models\Category;
use App\MoonShine\Fields\PostImage;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;

class CategoryResource extends ModelResource
{
    protected string $model = Category::class;

    protected string $title = 'Категории';
    protected array $activeActions = ['create', 'show', 'edit', 'delete'];
    protected string $column = 'title';
    protected bool $showInModal = true;

    public function fields(): array
    {
        return [
            Switcher::make('Опубл.', 'active'),
            Text::make('Title', 'title')
                ->sortable()
                ->required(),
            Text::make('url')->required(),
            PostImage::make('preview'),
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

    public function components(): array
    {
        return [
        //    ChangeLogFormComponent::make('Change log'),
        ];
    }
}
