<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('posts', PostController::class, [ 'only' => ['index', 'show'] ] );

//Route::resource('posts', PostController::class );
Route::get('/user/info/{id}', [UserController::class, 'userInfo']);
Route::get('/user/follows', [UserController::class, 'getFollows']);
Route::get('/user/check-login', [UserController::class, 'checkLogin']);

Route::group(['middleware' => 'auth:sanctum'], function(){

    Route::get('/user/subscribe/{subscription}', [UserController::class, 'subscribe']);
    Route::get('/user/unsubscribe/{subscription}', [UserController::class, 'unsubscribe']);
    Route::resource('posts', PostController::class, [ 'only' => ['store', 'create', 'update', 'destroy', 'edit'] ] );
});
