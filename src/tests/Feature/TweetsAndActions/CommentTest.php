<?php

namespace Tests\Feature\TweetsAndActions;

use App\Models\Tweet;
use App\Models\User;
use App\Models\Like;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_comment_on_a_tweet()
    {
        $user = User::factory()->create();

        $tweet= Tweet::factory()->create();

        $response = $this->actingAs($user)->postJson(route('comments.store', $tweet->id), [
            'body' => 'Commenting on a tweet'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'body' => 'Commenting on a tweet',
                'user_id' => $user->id
            ]);

        $this->assertEquals(1, $tweet->refresh()->comments()->count());

        $this->assertDatabaseHas('comments', [
            'body' => 'Commenting on a tweet',
            'user_id' => $user->id,
            'tweet_id' => $tweet->id
        ]);
    }
}
