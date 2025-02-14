<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show($username)
    {
        $user = User::where('username', $username)
            ->withCount(['followers', 'following'])
            ->firstOrFail();


        return view('user.profile', [
            'user' => $user,
            'isCurrentUser' => auth()->id() === $user->id,
             'isFollowing' => auth()->user()->isFollowing($user)
        ]);

    }

    public function tweets($username): \Illuminate\Http\JsonResponse
    {
        $user = User::where('username', $username)->firstOrFail();
        return response()->json($user->tweets()->with('user')->latest()->get());
    }
}
