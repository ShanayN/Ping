<?php

namespace Tests\Feature\TweetsAndActions;

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TweetTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_fetch_tweets()
    {
        // Create a user
        $user = User::factory()->create();
        // Create tweets for user
        $tweets = Tweet::factory()->count(5)->for($user)->create();

        // Fetch tweets
        $response = $this->actingAs($user)->getJson('/tweets');

        // Assert response
        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'content', 'likes_count', 'comments_count', 'liked_by_user', 'created_at', 'user']
                ]
            ]);
    }

    public function test_user_can_create_tweet()
    {
        // Create a user
        $user = User::factory()->create();
        // Create a tweet
        $tweetData = ['content' => 'Tweet Tweet'];

        // Create a tweet and post to end point
        $response = $this->actingAs($user)->postJson('/tweets', $tweetData);

        // Assert response
        $response->assertCreated()
            ->assertJsonFragment(['content' => 'Tweet Tweet']);

        // Check in DB that tweet was created
        $this->assertDatabaseHas('tweets', ['content' => 'Tweet Tweet', 'user_id' => $user->id]);
    }
}
