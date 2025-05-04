<?php

declare(strict_types=1);

namespace Modules\Auth\Infrastructure\Adapter\Out\Persistence;

use Modules\Auth\Domain\Entities\User as DomainUser;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;
use Modules\Auth\Domain\ValueObjects\Email;
use Modules\Auth\Infrastructure\Adapter\Out\Persistence\EloquentModels\UserModel;
use Laravel\Sanctum\PersonalAccessToken;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function save(DomainUser $user): DomainUser
    {
        $model = UserModel::updateOrCreate(
            ['id' => $user->id],
            [
                'name'     => $user->name,
                'email'    => $user->email->value(),
                'password' => $user->passwordHash,
            ],
        );

        return $model->toDomain();
    }

    public function findByEmail(Email $email): ?DomainUser
    {
        $model = UserModel::where('email', $email->value())->first();

        return $model?->toDomain();
    }

    public function createApiToken(DomainUser $user): string
    {
        /** @var UserModel $model */
        $model = UserModel::findOrFail($user->id);

        return $model->createToken('api')->plainTextToken;
    }

    public function revokeCurrentToken(DomainUser $user): void
    {
        PersonalAccessToken::where('tokenable_id', $user->id)->delete();
    }
}
