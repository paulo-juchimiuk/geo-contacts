<?php

declare(strict_types=1);

namespace App\Modules\Auth\Application\UseCases;

use Illuminate\Support\Facades\Hash;
use Modules\Auth\Domain\Entities\User;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;
use Modules\Auth\Domain\ValueObjects\Email;

readonly class RegisterUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $users
    ) {}

    /** @return array{id:int,name:string,email:string,token:string} */
    public function __invoke(string $name, string $email, string $password): array
    {
        $entity = new User(
            id: null,
            name: $name,
            email: new Email($email),
            passwordHash: Hash::make($password),
        );

        $saved = $this->users->save($entity);
        $token = $this->users->createApiToken($saved);

        return ['id'=>$saved->id,'name'=>$saved->name,'email'=>$saved->email,'token'=>$token];
    }
}
