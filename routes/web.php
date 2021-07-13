<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('posts', PostController::class)->names("posts")->except(['create', 'edit']);
Route::resource('posts.likes', PostLikeController::class)->names('posts.likes')->except(['show', 'create', 'edit', 'destroy', 'update']);
Route::get('posts/{post}/likes/{user}', [PostLikeController::class, 'show'])->name('posts.likes.show');
Route::resource('posts.comments', CommentController::class)->names("comments")->shallow()->except(['show', 'edit', 'create']);

Route::get('login/google', [LoginController::class, 'redirectToProvider'])->name('social.auth');
Route::get('logout', [LoginController::class, 'logout'])->name('social.auth.logout');
Route::get('login/google/callback', [LoginController::class, 'handleProviderCallback'])->name('social.callback');
