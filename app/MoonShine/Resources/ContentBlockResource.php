<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Enums\ImageEnum;
use App\Models\ContentBlock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use MoonShine\ChangeLog\Components\ChangeLog;
use MoonShine\Enums\ClickAction;
use MoonShine\Enums\Layer;
use MoonShine\Fields\Date;
use MoonShine\Fields\DateRange;
use MoonShine\Fields\ID;
use MoonShine\Fields\Relationships\MorphToMany;
use MoonShine\Fields\Text;
use MoonShine\Fields\TinyMce;
use MoonShine\Resources\ModelResource;

class ContentBlockResource extends ModelResource
{
    protected string $model = ContentBlock::class;

    protected string $title = 'Блоки контента';

    protected ?ClickAction $clickAction = ClickAction::EDIT;

    protected array $with = ['images', 'posts'];
    protected bool $detailInModal = true;
    protected int $itemsPerPage = 200;

    public function fields(): array
    {
        return [
            ID::make(),
            Text::make('Название', 'name')
                ->required(),
            Text::make('Заголовок H2', 'title')
                ->required(),
            TinyMce::make('Текст', 'description')
                ->hideOnIndex(),
            Date::make('Добавлено', 'created_at')
                ->readonly()
                ->hideOnIndex(),
            MorphToMany::make(
                'Изображения',
                'images',
                fn($item) => $item->name

            )
                ->selectMode()
                ->creatable()
                ->inLine(separator: ' ', badge: true)
                ->withImage(
                    'slug',
                    'public',
                    ImageEnum::GALLERY_PREVIEW['dir']
                )
                ->hideOnIndex(),
            MorphToMany::make('Изображения', 'images', function ($item) {
                return '<img alt="" src="' . Storage::url(ImageEnum::GALLERY_PREVIEW['dir'] . $item->slug) . '">'
                    . '<small>' . $item->name . '</small>';
            })
                ->inLine(separator: ' ', badge: false)
                ->creatable()
                ->hideOnForm(),
            MorphToMany::make(
                'Прикреплен к постам',
                'posts',
                fn($item) => $item->title
            )
                ->selectMode(),

            MorphToMany::make('Изображения', 'images', function ($item) {
                return '<img alt="" src="' . Storage::url(ImageEnum::GALLERY_PREVIEW['dir'] . $item->slug) . '">'
                    . '<small>' . $item->name . '</small>';
            })
                ->associatedWith('content_block_id'),


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
