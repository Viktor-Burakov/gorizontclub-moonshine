<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\ContentBlock;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Resources\ModelResource;

class ContentBlockResource extends ModelResource
{
    protected string $model = ContentBlock::class;

    protected string $title = 'BlockContents';

    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
            ]),
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }
}
