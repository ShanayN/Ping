<?php

namespace Tests\Feature\Profiles;

use App\Models\Tweet;
use App\Models\User;
use App\Models\Follow;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FollowTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_follow_another()
    {
        // Create follower - userA
        $userA = User::factory()->create();

        // Authenticate user A
        $this->actingAs($userA);

        // Create UserB
        $userB = User::factory()->create();

        // Follow User B - send post request to the follow end point
        $response = $this->postJson(route('follow', $userB->username), []);


        $response->assertStatus(200);

        // Check in DB if the follow ids exist
        $this->assertDatabaseHas('follows', [
            'follower_id' => $userA->id,
            'following_id' => $userB->id
        ]);
    }

    public function test_a_user_can_unfollow_another()
    {
        // Create userA and B
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        // Authenticate USerA
        $this->actingAs($userA);

        // Create follow record
        $follow = Follow::create([
            'follower_id' => $userA->id,
            'following_id' => $userB->id
        ]);

        // Unfollow UserB
        $response = $this->postJson(route('unfollow', $userB->username), []);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('follows', [
            'follower_id' => $userA->id,
            'following_id' => $userB->id
        ]);
    }
}
