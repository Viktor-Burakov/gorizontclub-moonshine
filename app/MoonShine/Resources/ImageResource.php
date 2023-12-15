<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Enums\ImageEnum;
use Illuminate\Database\Eloquent\Model;
use MoonShine\ChangeLog\Components\ChangeLog;
use MoonShine\Enums\ClickAction;
use MoonShine\Enums\Layer;
use MoonShine\Fields\Date;
use MoonShine\Fields\DateRange;
use MoonShine\Fields\ID;
use MoonShine\Fields\Image;
use MoonShine\Fields\Relationships\MorphToMany;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;


class ImageResource extends ModelResource
{
    protected string $model = \App\Models\Image::class;

    protected string $title = 'Изображения к постам';
    protected ?ClickAction $clickAction = ClickAction::EDIT;

    protected array $with = ['posts', 'contentBlocks'];
    protected int $itemsPerPage = 200;

    public function fields(): array
    {
        return [
            ID::make(),
            Text::make('Название', 'name')
                ->required(),
            Text::make('Alt', 'alt'),
            Image::make('Превью', 'url')
                ->dir(ImageEnum::GALLERY_PREVIEW['dir']),
            Date::make('Добавлено', 'created_at'),
            MorphToMany::make(
                'Прикреплен к блокам',
                'contentBlocks',
                fn($item) => $item->name
            )
                ->inLine(separator: ' ', badge: true)
                ->selectMode(),
            MorphToMany::make(
                'Прикреплен к постам',
                'posts',
                fn($item) => $item->title
            )
                ->inLine(separator: ' ', badge: true)
                ->selectMode()
        ];
    }

    public function filters(): array
    {
        return [
            DateRange::make('created_at'),
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }

    protected function onBoot(): void
    {
        $this->getPages()
            ->formPage()
            ->pushToLayer(
                Layer::BOTTOM,
                ChangeLog::make('Changelog', $this)
            );
    }
}
