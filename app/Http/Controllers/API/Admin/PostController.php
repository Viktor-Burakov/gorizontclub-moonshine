<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Admin;

use App\Actions\Post\PostCreateOrUpdateAction;
use App\Actions\Post\PostEditAction;
use App\Actions\Post\PostImagesCreateOrUpdateAction;
use App\Actions\Post\PostIndexAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostCreateOrUpdateRequest;
use App\Http\Requests\Post\PostImagesCreateOrUpdateRequest;
use App\Http\Requests\Post\StoreRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    public function index(PostIndexAction $action): JsonResponse
    {
        return response()->json($action());
    }


    public function edit(int $id, PostEditAction $action): JsonResponse
    {
        return response()->json($action($id));
    }

    public function store(StoreRequest $request, PostCreateOrUpdateAction $action): Response
    {
        $action($request->validated());

        return response()->json(['message' => 'Пост добавлен!']);
    }

    public function update(PostCreateOrUpdateRequest $request, PostCreateOrUpdateAction $action): Response
    {
        return response()->json(['message' => $action($request->validated())]);
    }

    public function imagesUpdate(PostImagesCreateOrUpdateRequest $request, PostImagesCreateOrUpdateAction $action): Response
    {
        $res = $action($request->validated());

        return response()->json([
            'message' => $res['message'],
            'err' => $res['err'],
            ]);
    }

    public function destroy(string $id)
    {
        //
    }
}
