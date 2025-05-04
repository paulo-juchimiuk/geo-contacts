<?php

declare(strict_types=1);

namespace App\Modules\Auth\Application\UseCases;

use Illuminate\Support\Facades\Hash;
use Modules\Auth\Domain\Entities\User as DomainUser;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;
use Modules\Auth\Domain\ValueObjects\Email;

readonly class RegisterUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $usersRepository
    ) {}

    public function __invoke(string $name, string $email, string $password): array
    {
        $entity = new DomainUser(
            id: null,
            name: $name,
            email: new Email($email),
            passwordHash: Hash::make($password),
        );

        $saved = $this->usersRepository->save($entity);
        $token = $this->usersRepository->createApiToken($saved);

        return ['id'=>$saved->getId(),'name'=>$saved->getName(),'email'=>$saved->getEmail(),'token'=>$token];
    }
}
