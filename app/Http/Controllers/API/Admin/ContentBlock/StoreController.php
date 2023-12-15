<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Admin\ContentBlock;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContentBlock\StoreRequest;
use App\Models\ContentBlock;
use Symfony\Component\HttpFoundation\Response;


class StoreController extends Controller
{
    public function __invoke(StoreRequest $request): Response
    {
        $data = $request->validated();
        $postId = $data['post_id'];
        unset($data['post_id']);

        $contentBlock = ContentBlock::firstOrCreate($data);

        $contentBlock->posts()->attach($postId);

        return response()->json(['message' => 'Блок добавлен!']);
    }
}
