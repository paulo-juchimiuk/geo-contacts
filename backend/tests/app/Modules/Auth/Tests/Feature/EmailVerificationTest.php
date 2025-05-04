<?php

namespace Tests\app\Modules\Auth\Tests\Feature;

use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Modules\Auth\Infrastructure\Adapter\Out\Persistence\EloquentModels\UserModel;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_can_be_verified(): void
    {
        $user = UserModel::factory()->unverified()->create();

        $token = $user->createToken('api')->plainTextToken;

        Event::fake();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson($verificationUrl)
            ->assertStatus(302);

        Event::assertDispatched(Verified::class);
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }

    public function test_email_is_not_verified_with_invalid_hash(): void
    {
        $user  = UserModel::factory()->unverified()->create();
        $token = $user->createToken('api')->plainTextToken;

        $invalidUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1('wrong-email')]
        );

        $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson($invalidUrl)
            ->assertStatus(403);

        $this->assertFalse($user->fresh()->hasVerifiedEmail());
    }
}
