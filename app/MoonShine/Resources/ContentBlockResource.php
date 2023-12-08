<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Enums\ImageEnum;
use App\Models\ContentBlock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use MoonShine\Enums\ClickAction;
use MoonShine\Fields\Date;
use MoonShine\Fields\ID;
use MoonShine\Fields\Relationships\BelongsToMany;
use MoonShine\Fields\Text;
use MoonShine\Fields\TinyMce;
use MoonShine\Resources\ModelResource;

class ContentBlockResource extends ModelResource
{
    protected string $model = ContentBlock::class;

    protected string $title = 'Блоки контента';

    protected ?ClickAction $clickAction = ClickAction::EDIT;

    protected int $itemsPerPage = 20;

    public function fields(): array
    {
        return [
            Text::make('Название', 'name')
                ->required(),
            Text::make('Заголовок H2', 'title')
                ->required(),
            TinyMce::make('Текст', 'description'),
            Date::make('Добавлено', 'created_at')
            ->readonly()
            ->hideOnIndex(),
            BelongsToMany::make(
                'Изображения',
                'images',
                fn($item) => $item->name

            )
                ->selectMode()
                ->inLine(separator: ' ', badge: true)
                ->withImage(
                    'url',
                    'public',
                    ImageEnum::GALLERY_PREVIEW['dir']
                )
            ->hideOnIndex(),
            BelongsToMany::make('Изображения', 'images', function (\App\Models\Image $image) {
                return '<img alt="" src="'. Storage::url(ImageEnum::GALLERY_PREVIEW['dir'] . $image->url)  .'">'
                    . '<small>'.$image->name.'</small>';
            })
                ->inLine(separator: ' ', badge: false)
                ->hideOnForm(),
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
