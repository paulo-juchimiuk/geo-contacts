<?php

namespace Tests\app\Modules\Auth\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_users_can_register_via_api(): void
    {
        $response = $this->postJson('/api/register', [
            'name'                  => 'Test User',
            'email'                 => 'test@example.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ])->assertStatus(201)
            ->assertJsonStructure([
                'code',
                'message',
                'details' => [
                    'id',
                    'name',
                    'email',
                    'token',
                ],
            ]);

        $this->assertSame(201, $response->json('code'));
        $this->assertNotEmpty($response->json('details.token'));
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }
}
