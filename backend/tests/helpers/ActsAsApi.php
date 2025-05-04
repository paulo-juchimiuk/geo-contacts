<?php

declare(strict_types=1);

namespace Tests\helpers;

use Illuminate\Support\Facades\Hash;
use Modules\Auth\Infrastructure\Adapter\Out\Persistence\EloquentModels\UserModel;

trait ActsAsApi
{
    protected function actingAsApi(): array
    {
        $user  = UserModel::factory()->create([
            'password' => Hash::make('secret'),
        ]);

        $token = $user->createToken('api')->plainTextToken;

        return [$user, $this->withHeader('Authorization', "Bearer {$token}")];
    }
}
