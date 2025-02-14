<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    // follow a user
    public function store(User $user): \Illuminate\Http\JsonResponse
    {
        if ($user->id === auth()->id()) {
            return response()->json(['message' => 'You cannot follow yourself'], 422);
        }

        if(auth()->user()->following()->where('following_id', $user->id)->exists()) {
            return response()->json(['message' => 'You are already following this user'], 422);
        }

        auth()->user()->following()->attach($user->id);
        return response()->json(['message' => 'Successfully followed user']);
    }

    // unfollow a user
    public function destroy(User $user): \Illuminate\Http\JsonResponse
    {
        if ($user->id === auth()->id()) {
            return response()->json(['message' => 'You cannot unfollow yourself'], 422);
        }

        if (!auth()->user()->following()->where('following_id', $user->id)->exists()) {
            return response()->json(['message' => 'You are not following this user'], 404);
        }

        auth()->user()->following()->detach($user->id);
        return response()->json(['message' => 'Successfully unfollowed user']);
    }
}
