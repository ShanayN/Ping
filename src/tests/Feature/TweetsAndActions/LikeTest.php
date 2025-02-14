<?php

namespace Tests\Feature\TweetsAndActions;

use App\Models\Tweet;
use App\Models\User;
use App\Models\Like;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_like_a_tweet()
    {
        // Create a user
        $user = User::factory()->create();

        // Create a tweet
        $tweet = Tweet::factory()->create();

        // Like the tweet
        $response = $this->actingAs($user)->postJson(route('tweets.like', $tweet->id), []);

        //  Assert the tweet is liked
        $response->assertStatus(200)
            ->assertJson([
                'liked_by_user' => true,
                'likes_count' => 1,
                'message' => 'Tweet Liked'
            ]);

        // Assert the tweet count is 1
        $this->assertEquals(1, $tweet->refresh()->likes()->count());

        // Assert the like is in the database
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'tweet_id' => $tweet->id
        ]);
    }

    public function test_a_user_can_unlike_a_tweet()
    {
        // Create a user
        $user = User::factory()->create();

        // Create a tweet and like
        $tweet = Tweet::factory()->create();
        $like = Like::create([
            'user_id' => $user->id,
            'tweet_id' => $tweet->id,
        ]);

        //  Assert the tweet is liked in DB
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'tweet_id' => $tweet->id,
        ]);

        // Post request to unlike tweet
        $response = $this->actingAs($user)->postJson(route('tweets.like', $tweet->id), []);

        // Assert tweet unliked
        $response->assertJson([
            'message' => 'Tweet Unliked',
        ]);

        // Assert the like is not in the database
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'tweet_id' => $tweet->id,
        ]);
    }
}
