<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_register_successfully()
    {
        // Create a new user
        $attributes = [
            'full_name' => 'Snow White',
            'date_of_birth' => '2000-01-01',
            'username' => 'snowwhite',
            'email' => 'snow@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        // Post request to register end point
        $response = $this->postJson('/register', $attributes);

        // Assert response
        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Registration successful',
            ]);

        // Assert DB has the user
        $this->assertDatabaseHas('users', [
            'full_name' => 'Snow White',
            'date_of_birth' => '2000-01-01',
            'username' => 'snowwhite',
            'email' => 'snow@example.com',
        ]);

        // Assert user is logged in
        $user = User::where('email', 'snow@example.com')->first();

        // Assert the password is hashed
        $this->assertTrue(Hash::check('password123', $user->password));

        // Asser the user is authenticated
        $this->assertAuthenticatedAs($user);
    }

    public function test_registration_fails_with_invalid_data()
    {
        // Testing the registration with empty data
        $response = $this->postJson('/register', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['full_name', 'date_of_birth', 'username', 'email', 'password']);
    }
}
