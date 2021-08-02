<?php

namespace App\Http\Controllers;

use App\Events\NewPostFollowed;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize(Post::class);
        return PostResource::collection(Post::with('user')->orderBy('id', 'DESC')->cursorPaginate(4));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests\StorePostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $this->authorize(Post::class);
        $imagen = null;
        if($request->file('imagen')){
            $imagen = $request->file('imagen')->store('public/imagenes');
        }

        $post = Post::create([
            "descripcion" => $request->descripcion,
            "imagen" => $imagen,
            "user_id" => $request->user()->id,
        ]);

        NewPostFollowed::dispatch($request->user(), $post);

        return new PostResource(Post::with('user')->find($post->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if($request->get('notification')){
            $request->user()->notifications->where("id", $request->get('notification'))->markAsRead();
        }

        $post = Post::with('user')->findOrFail($id);
        $this->authorize($post);
        return view('post.show', compact('post'));
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
        $post = Post::find($id);
        $post->update($request->all());
        return response()->json("ok");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $post = Post::find($id);
        $this->authorize($post);
        $post->delete();

        DB::table('notifications')->where('data->post', $id)->where('data->tipo', 'newPostFollowed')->where('data->user->id', Auth::user()->id)->delete();

        if($request->ajax()){
            return response()->json('ok');
        }
        return redirect()->route('home');
    }
}
