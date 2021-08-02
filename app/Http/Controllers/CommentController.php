<?php

namespace App\Http\Controllers;

use App\Events\NewComment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Environment\Console;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $this->authorize(Comment::class);
        return new CommentCollection(Comment::with('user')->where('post_id', $id)->orderBy('id', 'desc')->cursorPaginate(3));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreCommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, StoreCommentRequest $request)
    {
        $post = Post::find($id);
        $this->authorize(Comment::class);
        if(!$request->user()){
            return "";
        }

        $comment = Comment::create([
            "descripcion" => $request->descripcion,
            "user_id" => $request->user()->id,
            "post_id" => $id,
            "gif_url" => $request->gif_url,
        ]);

        if($post->user_id != $request->user()->id){
            NewComment::dispatch($post, $request->user(), $comment);
        }

        return response()->json([
            "id" => $comment->id,
            "count" => $post->comments()->count()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);
        $this->authorize($comment);
        $comment->update([
            "descripcion" => $request->descripcion
        ]);
        return response()->json("ok");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);
        $this->authorize($comment);
        $postId = $comment->post_id;
        $comment->delete();

        DB::table('notifications')->where('data->post', $postId)->where('data->tipo', 'commentPost')->where('data->user->id', Auth::user()->id)->delete();

        return response()->json([
            "count" => Post::find($postId)->comments()->count()
        ]);
    }
}
