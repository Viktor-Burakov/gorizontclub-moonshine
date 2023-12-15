<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Admin\Image;

use App\Http\Controllers\Controller;
use App\Http\Requests\Image\StoreRequest;
use App\Models\Image;
use App\Services\ImageService;
use Symfony\Component\HttpFoundation\Response;


class StoreController extends Controller
{
    public function __invoke(StoreRequest $request): Response
    {
        $data = $request->validated();

        foreach ($data['images'] as $imageFile) {
            if ($imageFile->isValid()) {
                if (!empty($data['content_block_id'])) {
                    $name = $data['content_block_title'];
                } else {
                    $name = $imageFile->getClientOriginalName();
                }

                $image = new Image();
                $image->name = $name;
                $image->save();

                $slug = str_slug($image->name . '-' . $image->id);

                ImageService::generateThumbnails($imageFile->path(), $slug);

                $image->path = $slug . '.jpg';
                $image->url = $slug . '.jpg';
                $image->save();
                $image->posts()->attach($data['post_id']);
                if (!empty($data['content_block_id'])) {
                    $image->contentBlocks()->attach($data['content_block_id']);
                }
            }
        }

        return response()->json(['message' => ['Изображения добавлены!']]);
    }
}
