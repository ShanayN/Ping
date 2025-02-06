<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegisterUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store()
    {
        $attributes = request()->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        $attributes['password'] = Hash::make($attributes['password']);

        $user = User::create($attributes);

        if ($user) {
            Auth::login($user);

            return response()->json([
                'message' => 'Registration successful',
                'user' => $user
            ], 201);
        }

        return response()->json([
            'message' => 'User registration failed'
        ], 500);
    }
}


