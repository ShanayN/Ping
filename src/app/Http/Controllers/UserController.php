<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'full_name' => $user->full_name,
            'email' => $user->email,
            'username' => $user->username,
            'avatar' => $user->avatar
        ]);
    }
}
