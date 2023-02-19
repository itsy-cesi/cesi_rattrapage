<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function getAllPosts()
    {
        $posts = Post::all();

        $data = [];

        foreach ($posts as $post)
        {
            $data[] = [
                'id' => $post->id,
                'message' => $post->message,
                'author_id' => $post->author_id,
                'media_1' => $post->media_1,
                'media_2' => $post->media_2,
                'media_3' => $post->media_3,
                'media_4' => $post->media_4,
                'post_date' => $post->post_date->format('Y-m-d H:i:s'),
            ];
        }

        return $data;
    }



    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'message' => 'required|string',
            'media_1' => 'nullable|string',
            'media_2' => 'nullable|string',
            'media_3' => 'nullable|string',
            'media_4' => 'nullable|string',
        ]);

        $post = new Post($validatedData);
        $post->author_id = auth()->user()->userId;
        $post->post_date = now();
        $post->save();

        return ('work');
    }


    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function destroy(Request $request)
    {
        $validatedData = $request->validate([
            'post_id' => 'required|exists:posts,id',
        ]);

        $post = Post::find($validatedData['post_id']);

        if (auth()->user()->id !== $post->author_id)
        {
            return response()->json(['message' => 'You are not authorized to delete this post.'], 403);
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully.'], 200);
    }
}
