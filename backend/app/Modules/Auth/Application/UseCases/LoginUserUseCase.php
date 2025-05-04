<?php

declare(strict_types=1);

namespace Modules\Auth\Application\UseCases;

use Illuminate\Support\Facades\Hash;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;
use Modules\Auth\Domain\ValueObjects\Email;

readonly class LoginUserUseCase
{
    public function __construct(private UserRepositoryInterface $usersRepository) {}

    public function __invoke(string $email, string $password): ?array
    {
        $user = $this->usersRepository->findByEmail(new Email($email));

        if (! $user || ! Hash::check($password, $user->getPasswordHash())) {
            return null;
        }

        $token = $this->usersRepository->createApiToken($user);

        return [
            'id'    => $user->getId(),
            'name'  => $user->getName(),
            'email' => $user->getEmail()->value(),
            'token' => $token,
        ];
    }
}
