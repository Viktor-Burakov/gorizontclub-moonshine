<?php

use App\Http\Controllers\API\Admin\CategoryController;
use App\Http\Controllers\API\Admin\ContentBlockController;
use App\Http\Controllers\API\Admin\ImageController;
use App\Http\Controllers\API\Admin\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'admin'], function () {
    Route::group(['prefix' => 'category'], function () {
        Route::get('/', [CategoryController::class, 'index'])
            ->name('category.index');
    });

    Route::group(['prefix' => 'post'], function () {
        Route::get('/', [PostController::class, 'index'])
            ->name('post.index');

        Route::get('/{id}', [PostController::class, 'edit'])
            ->name('post.edit')
            ->where(['id' => '[0-9]+']);

        Route::post('/{id}', [PostController::class, 'update'])
            ->name('post.update')
            ->where(['id' => '[0-9]+']);

        Route::post('/', [PostController::class, 'store'])
            ->name('post.store');
    });


    Route::group(['prefix' => 'contentBlock'], function () {
        Route::post('/', [ContentBlockController::class, 'store'])
            ->name('content-block.store');
    });
    Route::group(['prefix' => 'image'], function () {
        Route::post('/', [ImageController::class, 'store'])
            ->name('image.store');
    });
});
