<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\RegisterUserController;
use Illuminate\Support\Facades\Route;

Route::get('/',[ LandingPageController::class, 'index' ]);

// Auth
Route::get('/register', [RegisterUserController::class, 'create']);
