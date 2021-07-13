<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
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
        if(!$request->page){
            $comments = Comment::with('user')->where('post_id', $id)->paginate(3);
            return redirect($comments->url($comments->lastPage()));
        }
        return Comment::with('user')->where('post_id', $id)->paginate(3);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, Request $request)
    {

        if(!$request->user()){
            return "";
        }

        $comment = Comment::create([
            "descripcion" => $request->descripcion,
            "user_id" => $request->user()->id,
            "post_id" => $id
        ]);

        return response()->json([
            "id" => $comment->id,
            "count" => Post::find($id)->comments()->count()
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
        $postId = $comment->post_id;
        $comment->delete();
        return response()->json([
            "count" => Post::find($postId)->comments()->count()
        ]);
    }
}
