<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Admin;

use App\Actions\ContentBlock\ContentBlockIndexAction;
use App\Actions\Image\ImageIndexAction;
use App\Actions\Post\PostCreateOrUpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Image\ImageStoreRequest;
use App\Http\Requests\Post\StoreRequest;
use App\Models\Image;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ImageController extends Controller
{
    public function index(ImageIndexAction $action): JsonResponse
    {
        return response()->json($action->handle());
    }
    public function edit(string $postId)
    {
    }

    public function store(ImageStoreRequest $request): Response
    {
        $data = $request->validated();
        dump($request);
        dd($data);
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
                $image->slug = $slug . '.jpg';
                $image->save();
                $image->posts()->attach($data['post_id']);
                if (!empty($data['content_block_id'])) {
                    $image->contentBlocks()->attach($data['content_block_id']);
                }
            }
        }

        return response()->json(['message' => ['Изображения добавлены!']]);
    }

    public function update(StoreRequest $request, PostCreateOrUpdateAction $action)
    {
    }

    public function destroy(string $id)
    {
        //
    }
}
