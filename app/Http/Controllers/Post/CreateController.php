<?php

namespace App\Http\Controllers\Post;

use App\Models\Categories;


class CreateController extends BaseController
{
   public function __invoke()
   {
      $categories = Categories::all();

      return view('post.create', compact('categories'));
   }
}
