<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function create()
    {
        return view('user.dashboard');
    }
}
