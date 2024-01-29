<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Admin;

use App\Actions\Post\PostCreateOrUpdateAction;
use App\Actions\Post\PostEditAction;
use App\Actions\Post\PostIndexAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StoreRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    public function index(PostIndexAction $action): JsonResponse
    {
        return response()->json($action->handle());
    }


    public function edit(int $id, PostEditAction $action): JsonResponse
    {
        return response()->json($action->handle($id));
    }

    public function store(StoreRequest $request, PostCreateOrUpdateAction $action): Response
    {
        $action->handle($request->validated());

        return response()->json(['message' => 'Пост добавлен!']);
    }

    public function update(Request $request, PostCreateOrUpdateAction $action): Response
    {
        dump($request->title);

        dd($request->all());
        return response()->json($request->all());
        $action->handle($request->validated());

        return response()->json(['message' => 'Пост обновлен!']);
    }

    public function destroy(string $id)
    {
        //
    }
}
