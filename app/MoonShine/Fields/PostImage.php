<?php

declare(strict_types=1);

namespace App\MoonShine\Fields;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use MoonShine\Fields\File;

class PostImage extends File
{
    protected string $view = 'admin.fields.postImage';

    public function getAssets(): array
    {
        return [
            "/js/postImage.js",
            "/css/postimage.css"
        ];
    }
}
