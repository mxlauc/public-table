<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentLikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $this->authorize(Like::class);
        $miLike = false;
        $comment = Comment::find($id);
        $like = $comment->likes()->where('user_id', $request->user()->id)->get()->first();
        if($like){
            $like->delete();
            //TODO: add type to querys COMMENTS LIKE ETC...
            //DB::table('notifications')->where("data->post", $comment->id)->where("data->tipo", "likePost")->where("data->user->id", $request->user()->id)->delete();
        }else{
            $comment->likes()->create([
                "user_id" => $request->user()->id
            ]);
            $miLike = true;
            //NewLike::dispatch($comment, $request->user());
        }
        return response()->json([
            "miLike" => $miLike,
            "count" => Comment::find($id)->likes()->count()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

}
