<?php

declare(strict_types=1);

namespace Modules\Auth\Application\UseCases;

use Modules\Auth\Domain\Entities\User as DomainUser;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;

readonly class DeleteAccountUseCase
{
    public function __construct(private UserRepositoryInterface $usersRepository) {}

    public function __invoke(DomainUser $user): void
    {
        $this->usersRepository->delete($user);
    }
}
