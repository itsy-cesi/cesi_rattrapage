<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like(Request $request)
{
    $existingLike = Like::where('user_id', Auth::user()->id)
        ->where('message_id', $request->post_id)
        ->first();

    if ($existingLike) {
        $existingLike->delete();
        return json_encode(array('message'=> 'Post unliked successfully.', 'likes' => $this->countLikes($request->post_id)));
    }

    $like = Like::create([
        'user_id' => Auth::user()->id,
        'message_id' => $request->post_id,
    ]);

    if (!$like) {
        // the record could not be created, so return an error message
        return back()->with('error', 'An error occurred while liking the post.');
    }

    return json_encode(array('message'=> 'Post liked successfully.', 'likes' => $this->countLikes($request->post_id)));
}
    public function isLiked(Int $post_id){
        if ((Auth::user()->id ?? false) != false){
            $existingLike = Like::where('user_id', Auth::user()->id)
            ->where('message_id', $post_id)
            ->first();
        }

        return (bool)isset($existingLike)?$existingLike:false;
    }

    public function countLikes($post_id){
        return Like::where('message_id', $post_id)->count();
    }
}
