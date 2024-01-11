<?php

declare(strict_types=1);

namespace App\MoonShine\Fields;

use MoonShine\Fields\Relationships\MorphToMany;

class ContentBlocks extends MorphToMany
{
    protected string $view = 'admin.fields.contentBlocks';
}
