<?php

namespace App\Http\Controllers\Post;



class IndexController extends BaseController
{
   public function __invoke()
   {
      $posts = $this->service->index();
   
      return view('post.index', compact('posts'));
   }
}
