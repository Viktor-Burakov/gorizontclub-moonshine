<?php

namespace App\Http\Controllers\Post;

class DestroyController extends BaseController
{
   public function __invoke($uri)
   {
      $this->service->destroy($uri);

      return redirect()->route('main.index');
   }
}
