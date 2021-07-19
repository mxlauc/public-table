<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\UserController;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

Route::get('/@{id}', function ($id) {
    $user = User::where("user_name", $id)->get()->first();
    if($user){
        return view('user.show', compact('user'));
    }else{
        abort(404);
    }


});

Route::post('followers/{user}', function (Request $request, User $user) {

    $siguiendo = false;
    if(DB::table('user_user')->whereFollowerId($request->user()->id)->whereFollowedId($user->id)->count()){
        $request->user()->followeds()->detach($user->id);
    }else{
        $request->user()->followeds()->syncWithoutDetaching($user->id);
        $siguiendo = true;
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



Route::get('login/google', [LoginController::class, 'redirectToProvider'])->name('social.auth');
Route::get('logout', [LoginController::class, 'logout'])->name('social.auth.logout');
Route::get('login/google/callback', [LoginController::class, 'handleProviderCallback'])->name('social.callback');
