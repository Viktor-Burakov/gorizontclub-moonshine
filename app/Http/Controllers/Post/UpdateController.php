<?php

namespace App\Http\Controllers\Post;

use App\Http\Requests\Post\UpdateDetailRequest;
use App\Http\Requests\Post\UpdateRequest;

class UpdateController extends BaseController
{
    public function __invoke($uri, UpdateRequest $request, UpdateDetailRequest $requestDetail)
    {
        $data = $request->validated();

        $dataDetail = $requestDetail->validated();

        $this->service->update($data, $dataDetail, $uri);


        return redirect()->route('post.show', $data['slug']);
    }
}
