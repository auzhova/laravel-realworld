<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function test_get_current_user()
    {
        $response = $this->getJson('/api/user', $this->headers);

        $response->assertStatus(200)
            ->assertJson([
                'user' => [
                    'email' => $this->loggedInUser->email,
                    'username' => $this->loggedInUser->username,
                    'bio' => $this->loggedInUser->bio,
                    'image' => $this->loggedInUser->image,
                ]
            ]);
    }

    public function test_get_current_user_invalid_token()
    {
        $response = $this->getJson('/api/user', [
            'Authorization' => 'Bearer Invalid_token'
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'errors' => [
                    'message' => 'JWT error: Token is invalid',
                ]
            ]);
    }

    public function test_get_current_user_unauthorized()
    {
        $response = $this->getJson('/api/user');

        $response->assertStatus(401);
    }

    public function test_update_current_user()
    {
        $data = [
            'user' => [
                'username' => 'test12345',
                'email' => 'test12345@test.com',
                'password' => 'test12345',
                'bio' => 'hello',
                'image' => 'http://test.com/test.jpg',
            ]
        ];

        $response = $this->putJson('/api/user', $data, $this->headers);

        $response->assertStatus(200)
            ->assertJson([
                'user' => [
                    'username' => 'test12345',
                    'email' => 'test12345@test.com',
                    'bio' => 'hello',
                    'image' => 'http://test.com/test.jpg',
                ]
            ]);

        $this->assertTrue(auth()->once($data['user']), 'Password update failed');
    }
}
