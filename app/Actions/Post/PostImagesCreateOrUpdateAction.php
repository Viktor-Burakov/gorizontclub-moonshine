<?php

declare(strict_types=1);

namespace App\Actions\Post;

use App\Enums\PostEnum;
use App\Models\Post;
use App\Services\ImageService;

class PostImagesCreateOrUpdateAction
{
    public function __invoke($data): void
    {

        dd($data);
    }
}
