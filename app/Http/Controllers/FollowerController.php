<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Events\NewFollower as EventsNewFollower;

class FollowerController extends Controller
{
    public function follow(Request $request, User $user){
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
    }

    public function getFollowers(Request $request, User $user){
        $count = 0;
        if($request->user()){
            $count = DB::table('user_user')->whereFollowerId($request->user()->id)->whereFollowedId($user->id)->count();
        }
        $followers = DB::table('user_user')->whereFollowedId($user->id)->count();
        $followeds = DB::table('user_user')->whereFollowerId($user->id)->count();
        $posts = DB::table('posts')->whereUserId($user->id)->count();
        return response()->json([
            "following" => $count > 0,
            "followers" => $followers,
            "followeds" => $followeds,
            "posts" => $posts,
        ]);
    }
}
