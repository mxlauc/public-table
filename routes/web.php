<?php

use App\Events\NewFollower as EventsNewFollower;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentLikeController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPostsController;
use App\Http\Resources\NotificationCollection;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
Route::resource('comments.likes', CommentLikeController::class)->names('comments.likes')->except(['show', 'create', 'edit', 'destroy', 'update']);
Route::get('posts/{post}/likes/{user}', [PostLikeController::class, 'show'])->name('posts.likes.show');
Route::resource('posts.comments', CommentController::class)->names("comments")->shallow()->except(['show', 'edit', 'create']);
Route::resource('users', UserController::class)->names("users")->except(["index", "create", "store", "edit", "destroy"]);
Route::get('/@{user:user_name}', [UserController::class, 'show']);


Route::get('users/{id}/posts', [UserPostsController::class, 'posts']);


Route::post('followers/{user}', [FollowerController::class, 'follow'])->middleware('can:follow,user');
Route::get('followers/{user}', [FollowerController::class, 'getFollowers']);


Route::get('notificaciones', [NotificationController::class, 'index']);
Route::resource('notificaciones', NotificationController::class)->names('notificaciondes')->only(['destroy', 'update']);


Route::get('login/google', [LoginController::class, 'redirectToProvider'])->name('social.auth');
Route::get('logout', [LoginController::class, 'logout'])->name('social.auth.logout');
Route::get('login/google/callback', [LoginController::class, 'handleProviderCallback'])->name('social.callback');
