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
            ['id' => $user->getId()],
            [
                'name'     => $user->getName(),
                'email'    => $user->getEmail()->value(),
                'password' => $user->getPasswordHash(),
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
        $model = UserModel::findOrFail($user->getId());

        return $model->createToken('api')->plainTextToken;
    }

    public function revokeCurrentToken(DomainUser $user): void
    {
        PersonalAccessToken::where('tokenable_id', $user->getId())->delete();
    }

    public function delete(DomainUser $user): void
    {
        /** @var UserModel $model */
        $model = UserModel::findOrFail($user->getId());

        PersonalAccessToken::where('tokenable_id', $user->getId())->delete();

        $model->delete();
    }
}
