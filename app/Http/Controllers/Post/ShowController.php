<?php

namespace App\Http\Controllers\Post;

class ShowController extends BaseController
{
   public function __invoke($uri)
   {
      $post = $this->service->show($uri);

      return view('post.show', compact('post'));
   }
}
