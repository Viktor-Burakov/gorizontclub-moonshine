<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Admin;

use App\Actions\ContentBlock\ContentBlockCreateOrUpdateAction;
use App\Actions\ContentBlock\ContentBlockEditAction;
use App\Actions\ContentBlock\ContentBlockIndexAction;
use App\Actions\Post\PostCreateOrUpdateAction;
use App\Actions\Post\PostEditAction;
use App\Actions\Post\PostIndexAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContentBlock\ContentBlockStoreRequest;
use App\Http\Requests\Post\StoreRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ContentBlockController extends Controller
{
    public function index(ContentBlockIndexAction $action): JsonResponse
    {
        return response()->json($action());
    }
    public function edit(int $id, ContentBlockEditAction $action): JsonResponse
    {
        return response()->json($action($id));
    }

    public function store(ContentBlockStoreRequest $request, ContentBlockCreateOrUpdateAction $action): Response
    {
        $action($request->validated());

        return response()->json(['message' => 'Блок добавлен!']);
    }

    public function update(StoreRequest $request, PostCreateOrUpdateAction $action)
    {
    }

    public function destroy(string $id)
    {
        //
    }
}
