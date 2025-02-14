<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Tweet;

class LikeController extends Controller
{
    public function toggle(Tweet $tweet): \Illuminate\Http\JsonResponse
    {
        // Authenticated user
        $user = auth()->user();

        // Check if the user already likes tweet
        $existingLike = Like::where('user_id', $user->id)
            ->where('tweet_id', $tweet->id)
            ->first();

        // If user does then unlike tweet else like the tweet
        if ($existingLike) {
            $existingLike->delete();
            $liked_by_user = false;
        } else {
            Like::create([
                'user_id' => $user->id,
                'tweet_id' => $tweet-> id
            ]);
            $liked_by_user = true;
        }

        // Count number of likes
        $likes_count = $tweet->refresh()->likes()->count();

        return response()->json([
            'liked_by_user' => $liked_by_user,
            'likes_count' => $likes_count,
            'message' => $liked_by_user ? 'Tweet Liked' : 'Tweet Unliked'
        ]);
    }
}
