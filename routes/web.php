<?php

use App\Events\NewFollower as EventsNewFollower;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\UserController;
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
Route::get('posts/{post}/likes/{user}', [PostLikeController::class, 'show'])->name('posts.likes.show');
Route::resource('posts.comments', CommentController::class)->names("comments")->shallow()->except(['show', 'edit', 'create']);
Route::resource('users', UserController::class)->names("users")->except(["index", "create", "store", "edit", "destroy"]);

Route::get('users/{id}/posts', function ($id) {
    return PostResource::collection(Post::with('user')->where("user_id", $id)->orderBy('id', 'DESC')->paginate(4));
});

Route::get('/@{user:user_name}', [UserController::class, 'show']);

Route::post('followers/{user}', function (Request $request, User $user) {
    error_log('Some message here.');

    $siguiendo = false;
    if(DB::table('user_user')->whereFollowerId($request->user()->id)->whereFollowedId($user->id)->count()){
        $request->user()->followeds()->detach($user->id);
        DB::table('notifications')->where("notifiable_id", $user->id)->where("data->user->id", $request->user()->id)->delete();
    }else{
        $request->user()->followeds()->syncWithoutDetaching($user->id);
        $siguiendo = true;

        EventsNewFollower::dispatch($user, $request->user());
    }
    $followers = DB::table('user_user')->whereFollowedId($user->id)->count();
    $followeds = DB::table('user_user')->whereFollowerId($user->id)->count();
    $posts = DB::table('posts')->whereUserId($user->id)->count();
    return response()->json([
        "following" => $siguiendo,
        "followers" => $followers,
        "followeds" => $followeds,
        "posts" => $posts,
        ]);
})->middleware('can:follow,user');

Route::get('followers/{id}', function (Request $request, int $id) {
    $count = 0;
    if($request->user()){
        $count = DB::table('user_user')->whereFollowerId($request->user()->id)->whereFollowedId($id)->count();
    }
    $followers = DB::table('user_user')->whereFollowedId($id)->count();
    $followeds = DB::table('user_user')->whereFollowerId($id)->count();
    $posts = DB::table('posts')->whereUserId($id)->count();
    return response()->json([
        "following" => $count > 0,
        "followers" => $followers,
        "followeds" => $followeds,
        "posts" => $posts,
        ]);
});


Route::get('notificaciones', function (Request $request) {
    $notificaciones = DB::table('notifications')->get()->toArray();

    return view("notifications", compact("notificaciones"));
});

Route::get('misNotificaciones', function (Request $request) {
    return new NotificationCollection($request->user()->notifications()->paginate(10));
});

Route::resource('notificaciones', NotificationController::class)->names('notificaciondes')->only(['destroy', 'update']);


Route::get('login/google', [LoginController::class, 'redirectToProvider'])->name('social.auth');
Route::get('logout', [LoginController::class, 'logout'])->name('social.auth.logout');
Route::get('login/google/callback', [LoginController::class, 'handleProviderCallback'])->name('social.callback');
