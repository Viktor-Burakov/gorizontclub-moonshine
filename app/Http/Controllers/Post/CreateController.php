<?php

namespace App\Http\Controllers\Post;


use App\MoonShine\Forms\PostForm;

class CreateController extends BaseController
{
    public function __invoke()
    {
        return view('post.create', [
            'form' => PostForm::make(),
        ]);
    }
}
