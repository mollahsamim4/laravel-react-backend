<?php

use App\Http\Controllers\CategoryConroller;
use App\Http\Controllers\PostsController;
use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::get('/dashboard', function (Request $request) {
    return response([
        'user' => Auth::user(),
        'message' => 'Login success',
        'status' => 'success'
    ]);
});

Route::resource('/category', CategoryConroller::class);






require __DIR__ . '/auth.php';


Route::get('/test', [PostsController::class, 'test']);
