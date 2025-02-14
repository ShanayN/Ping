<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ExploreController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('explore');
    }

    public function show(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'query' => 'required|string|min:1'
        ]);

        $search =$request->input('query');

        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('full_name', 'LIKE', "%{$search}%")
                        ->orWhere('username', 'LIKE', "%{$search}%");

                });
            })
            ->paginate(10);

        return response()->json([
            'users' => $users
        ]);
    }
}
