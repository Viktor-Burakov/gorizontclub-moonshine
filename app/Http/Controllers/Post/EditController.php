<?php

namespace App\Http\Controllers\Post;

class EditController extends BaseController
{
   public function __invoke($uri)
   {
      $post = $this->service->edit($uri);

      return view('post.edit', compact('post'));
   }
}
