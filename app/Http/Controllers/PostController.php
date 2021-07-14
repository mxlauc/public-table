<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
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
        return Post::with('user')->orderBy('id', 'DESC')->paginate(4);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->user()){
            return; //no hay usuario
        }

        $imagen = null;
        if($request->file('imagen')){
            $imagen = $request->file('imagen')->store('public/imagenes');
        }

        Post::create([
            "descripcion" => $request->descripcion,
            "imagen" => $imagen,
            "user_id" => $request->user()->id,
        ]);

        return response()->json('ok');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::with('user')->find($id);
        return view('post.show', compact('post'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        Post::find($id)->delete();
        //return redirect()
        if($request->ajax()){
            return response()->json('ok');
        }
        return redirect()->route('home');
    }
}
