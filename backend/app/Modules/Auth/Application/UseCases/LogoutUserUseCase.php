<?php

declare(strict_types=1);

namespace Modules\Auth\Application\UseCases;

use Modules\Auth\Domain\Entities\User;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;

readonly class LogoutUserUseCase
{
    public function __construct(private UserRepositoryInterface $users) {}

    public function __invoke(User $user): void
    {
        $this->users->revokeCurrentToken($user);
    }
}
