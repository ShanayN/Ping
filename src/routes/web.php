<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ExploreController;

Route::get('/',[ LandingPageController::class, 'index' ]);

// Register
Route::get('/register', [RegisterUserController::class, 'create']);
Route::post('/register', [RegisterUserController::class, 'store']);

//LogIn
Route::get('/login', [SessionController::class, 'create']);
Route::post('/login', [SessionController::class, 'store']);

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'create']);

    // Tweets
    Route::get('/tweets', [TweetController::class, 'index'])->name('tweets.index');
    Route::post('/tweets', [TweetController::class, 'store']);

    // Tweets - Like / Unlike
    Route::post('/tweets/{tweet}/like', [LikeController::class, 'toggle'])->name('tweets.like');

    // Tweets - Comments
    Route::get('/tweets/{tweet}/comments', [CommentController::class, 'index']);
    Route::post('/tweets/{tweet}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);

    // User Profile
    Route::get('/user', [UserController::class, 'show']);

    // Follow / Unfollow a user
    Route::post('/follow/{user:username}', [FollowController::class, 'store'])->name('follow');
    Route::post('/unfollow/{user:username}', [FollowController::class, 'destroy'])->name('unfollow');
    Route::get('/isFollowing/{user}', [FollowController::class, 'checkFollow']);

    // Profile of a user
    Route::get('/profile/{username}', [ProfileController::class, 'show']);
    Route::get('/profile/{username}/tweets', [ProfileController::class, 'tweets']);

    // Explore
    Route::get('/explore', [ExploreController::class, 'index']);
    Route::get('/explore/users', [ExploreController::class, 'show']);

    // Logout
    Route::post('/logout', [SessionController::class, 'destroy']);
});
