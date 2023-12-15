<?php

namespace App\Http\Controllers\Post;

use App\Http\Requests\Post\StoreDetailRequest;
use App\Http\Requests\Post\StoreRequest;
use App\Models\PostDetail;
use App\Models\Posts;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request, StoreDetailRequest $requestDetail)
    {
        $data = $request->validated();

        $dataDetail = $requestDetail->validated();

        $this->service->store($data, $dataDetail);


        return redirect()->route('post.edit', $data['slug']);
    }
}
