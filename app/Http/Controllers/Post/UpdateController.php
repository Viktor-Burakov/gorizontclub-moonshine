<?php

namespace App\Http\Controllers\Post;

use App\Http\Requests\Post\UpdateRequest;
use App\Http\Requests\Post\UpdateDetailRequest;

class UpdateController extends BaseController
{
   public function __invoke($uri, UpdateRequest $request, UpdateDetailRequest $requestDetail)
   {
      $data = $request->validated();

      $dataDetail = $requestDetail->validated();

      $this->service->update($data, $dataDetail, $uri);
      

      return redirect()->route('post.show', $data['url']);
   }
}
