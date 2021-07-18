<?php

namespace App\Http\Controllers;

use App\Http\Resources\LikeResource;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($postId)
    {
        $this->authorize(Like::class);
        return LikeResource::collection(Post::find($postId)->likes()->with('user')->orderBy('id', 'DESC')->paginate(2));
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
        $post = Post::find($id);
        $like = $post->likes()->where('user_id', $request->user()->id)->get()->first();
        if($like){
            $like->delete();
        }else{
            $post->likes()->create([
                "user_id" => $request->user()->id
            ]);
            $miLike = true;
        }
        return response()->json([
            "miLike" => $miLike,
            "count" => Post::find($id)->likes()->count()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $postId, $userId)
    {
        $like = Post::find($postId)->likes()->where('user_id', $userId)->get()->first();


        $this->authorize('viewAny', Like::class);

        return response()->json([
            "miLike" => $like ? true : false,
            "count" => Post::find($postId)->likes()->count()
        ]);
    }


}
