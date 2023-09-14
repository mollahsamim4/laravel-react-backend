<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\RegisterController;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/user', function (Request $request) {
        return response(Auth::user());
    });

    Route::post('/logout', [LoginController::class, 'logout']);

    Route::resource('/posts', PostsController::class);
    Route::delete('/posts/{id}/{category?}', [PostsController::class, 'destroy']);
    Route::get('/getPostsByCustomNumber/{number}/{lastId}', [PostsController::class, 'getPostsByCustomNumber']);

    Route::get('/check-user-is-authenticated', function () {
        if (Auth::check()) {
            return response(['status' => true]);
        } else {
            return response(['status' => false]);
        }
    });
});


Route::resource('login', LoginController::class);
// Route::resource('register', RegisterController::class);

Route::get('/test', function () {

    $posts = PostResource::collection(Post::where('id', '>', 20)->limit(5)->get());
    return $posts;
});
