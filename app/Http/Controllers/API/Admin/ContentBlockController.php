<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Admin;

use App\Actions\ContentBlock\ContentBlockCreateOrUpdateAction;
use App\Actions\Post\PostCreateOrUpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContentBlock\ContentBlockStoreRequest;
use App\Http\Requests\Post\StoreRequest;
use Symfony\Component\HttpFoundation\Response;

class ContentBlockController extends Controller
{
    public function edit(string $postId)
    {
    }

    public function store(ContentBlockStoreRequest $request, ContentBlockCreateOrUpdateAction $action): Response
    {
        $action->handle($request->validated());

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
