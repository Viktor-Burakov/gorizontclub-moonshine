<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\View\View;


class HomeController extends Controller
{
    public function __invoke(): View
    {


        return view('welcome', [

        ]);
    }
}
