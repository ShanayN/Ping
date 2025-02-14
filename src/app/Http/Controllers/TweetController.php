<?php

namespace App\Http\Controllers;

use App\Models\Tweet;

class TweetController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $tweets = Tweet::with(['user', 'likes', 'comments'])
            ->withCount('likes', 'comments')
            ->latest()
            ->paginate(10)
            ->through(function ($tweet) {
                return [
                    'id' => $tweet->id,
                    'content' => $tweet->content,
                    'likes_count' => $tweet->likes_count,
                    'comments_count' => $tweet->comments_count,
                    'liked_by_user' => $tweet->likes->where('user_id', auth()->id())->isNotEmpty(),
                    'created_at' => $tweet->created_at,
                    'user' => [
                        'id' => $tweet->user->id,
                        'full_name' => $tweet->user->full_name,
                        'username' => $tweet->user->username,
                    ],
                ];
            });

        return response()->json($tweets);
    }

    public function store(): \Illuminate\Http\JsonResponse
    {
        request()->validate([
            'content' => ['required', 'string', 'max:280'],
            'image' => ['nullable', 'image', 'max:1024']
        ]);

        $tweet = auth()->user()->tweets()->create([
            'content' => request()->content,
        ]);

        if(request()->hasFile('image')) {
            $path = request()->file('image')->store('tweets', 'public');
            $tweet->update(['image_path' => $path]);
        }

        return response()->json($tweet->load('user'), 201);
    }
}
