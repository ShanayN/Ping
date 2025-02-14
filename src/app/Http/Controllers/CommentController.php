<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Tweet;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Tweet $tweet): \Illuminate\Http\JsonResponse
    {
        return response()->json($tweet->comments()->with('user')->latest()->get());
    }

    public function store(Request $request, Tweet $tweet): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'body' => 'required|string|max:500'
        ]);

        $comment = $tweet->comments()->create([
            'body' => $validated['body'],
            'user_id' => auth()->id()
        ]);

        return response()->json($comment->load('user'));
    }

    public function destroy(Comment $comment)
    {
        if($comment->user_id !== auth()->id()){
            return response()->json(['message'=>'Unauthorized'], 403);
        }

        $comment->delete();
        return response()->json(['message'=>'Comment deleted']);

    }
}
