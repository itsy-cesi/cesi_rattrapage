<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;

class PostController extends Controller
{
    public function getAllPosts(?int $id = null)
    {
        $likeController = new LikeController();
        $userController = new UserController();
        $posts = Post::orderByDesc('post_date')->where('parent', $id)->get();

        $data = [];
        foreach ($posts as $post)
        {
            if ($post->author_id != null) {
                $data[] = [
                    'parent' => $post->parent,
                    'id' => $post->id,
                    'message' => $post->message,
                    'author' => $userController->getUser($post->author_id),
                    'media_1' => $post->media_1,
                    'media_2' => $post->media_2,
                    'media_3' => $post->media_3,
                    'media_4' => $post->media_4,
                    'post_date' => $post->post_date->format('Y-m-d H:i:s'),
                    'is_liked' => $likeController->isLiked($post->id),
                    'likes' => intval($likeController->countLikes($post->id)),
                    'comments' => Post::orderByDesc('post_date')->where('parent', $post->id)->get()->count(),
                ];
            }
        }

        return $data;
    }



    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'parent' => 'integer|nullable',
            'message' => 'required|string',
            'media_1' => 'nullable|string',
            'media_2' => 'nullable|string',
            'media_3' => 'nullable|string',
            'media_4' => 'nullable|string',
        ]);

        $post = new Post($validatedData);
        $post->author_id = auth()->user()->id;
        $post->post_date = now();
        $post->save();

        return ('work');
    }


    public function show($id)
{
    $userController = new UserController();
    $likeController = new LikeController();
    $post = Post::find($id);
    return [
        'parent' => '',
        'id' => $post->id,
        'message' => $post->message,
        'author' => $userController->getUser($post->author_id),
        'media_1' => $post->media_1,
        'media_2' => $post->media_2,
        'media_3' => $post->media_3,
        'media_4' => $post->media_4,
        'post_date' => $post->post_date->format('Y-m-d H:i:s'),
        'is_liked' => $likeController->isLiked($post->id),
        'likes' => intval($likeController->countLikes($post->id)),
        'comment' => $this->getAllPosts($post->id)
    ];
}


    public function destroy(Request $request)
    {
        $validatedData = $request->validate([
            'postId' => 'required|exists:posts,id',
        ]);

        $post = Post::find($validatedData['postId']);

        if (auth()->user()->id !== $post->author_id)
        {
            return response()->json(['message' => 'You are not authorized to delete this post.'], 403);
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully.'], 200);
    }
}
