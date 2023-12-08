<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Enums\ImageEnum;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Enums\ClickAction;
use MoonShine\Fields\Date;
use MoonShine\Fields\ID;
use MoonShine\Fields\Image;
use MoonShine\Fields\Relationships\BelongsToMany;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;


class ImageResource extends ModelResource
{
    protected string $model = \App\Models\Image::class;

    protected string $title = 'Изображения к постам';
    protected ?ClickAction $clickAction = ClickAction::EDIT;

    protected int $itemsPerPage = 20;
    public function fields(): array
    {
        return [
            ID::make(),
            Text::make('Название', 'name')
                ->required(),
            Text::make('Alt','alt'),
            Image::make('Превью', 'url')
                ->dir(ImageEnum::GALLERY_PREVIEW['dir']),
            Date::make('Добавлено', 'created_at'),
            BelongsToMany::make(
                'Прикреплен к блокам',
                'contentBlocks',
                fn($item) => $item->name
            )
                ->inLine(separator: ' ', badge: true)
                ->selectMode(),
            BelongsToMany::make(
                'Прикреплен к постам',
                'posts',
                fn($item) => $item->title
            )
                ->inLine(separator: ' ', badge: true)
                ->selectMode()
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }
}
