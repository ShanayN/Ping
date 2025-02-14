<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_valid_credentials()
    {
        // Create a new user
        $user = User::factory()->create([
            'password' =>  Hash::make('password123')
        ]);

        // Post request to the login end point to login
        $response = $this->postJson('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        // Assert response
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Login successful',
            ]);

        // Assert the user is authenticated
        $this->assertAuthenticatedAs($user);

    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        // Create a new user
        $user = User::factory()->create([
            'password' => Hash::make('password123')
        ]);

        // Post request to the login end point with the wrong credentials
        $response = $this->postJson('/login', [
            'email' => $user->email,
            'password' => 'password1111',
        ]);

        // Assert response
        $response->assertStatus(422)
            ->assertJsonValidationErrors('email');

        // Assert the user is not authenticated
        $this->assertGuest();
    }

    public function test_user_can_logout()
    {
        // Create a new user
        $user = User::factory()->create();

        // Log user out
        $this->actingAs($user)
            ->postJson('/logout')
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Logged out successfully'
            ]);

        // Assert user is logged out
        $this->assertGuest();
    }
}
