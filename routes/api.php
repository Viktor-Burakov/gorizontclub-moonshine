<?php

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
    Route::group(['prefix' => 'contentBlock'], function () {
//    Route::get('/{id?}', \App\Http\Controllers\API\Post\ShowController::class)
//        ->where('id', '[0-9]+');
//    Route::get('/category/{id}', \App\Http\Controllers\API\Category\ShowController::class)
//        ->where('id', '[0-9]+');
        Route::post('/', \App\Http\Controllers\API\Admin\ContentBlock\StoreController::class);
    });
});
