<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', action: HomeController::class)
    ->name('home');


Route::group(['prefix' => 'post'], function () {
    Route::get('/create', App\Http\Controllers\Post\CreateController::class)
        ->name('post.create');
    Route::get('/', App\Http\Controllers\Post\CreateController::class)
        ->name('post.create');
    Route::get('/{post}', [\App\Http\Controllers\API\Admin\PostController::class, 'edit'])
        ->name('post.edit');
});
