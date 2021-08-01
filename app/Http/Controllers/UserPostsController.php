<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class UserPostsController extends Controller
{
    public function posts($id){
        return PostResource::collection(Post::with('user')->where("user_id", $id)->orderBy('id', 'DESC')->cursorPaginate(4));
    }
}
