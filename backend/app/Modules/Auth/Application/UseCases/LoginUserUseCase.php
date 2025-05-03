<?php
declare(strict_types=1);

namespace Modules\Auth\Application\UseCases;

use Illuminate\Support\Facades\Hash;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;
use Modules\Auth\Domain\ValueObjects\Email;

readonly class LoginUserUseCase
{
    public function __construct(private UserRepositoryInterface $users) {}

    public function __invoke(string $email, string $password): ?array
    {
        $user = $this->users->findByEmail(new Email($email));

        if (! $user || ! Hash::check($password, $user->passwordHash)) {
            return null;
        }

        $token = $this->users->createApiToken($user);

        return [
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email->value(),
            'token' => $token,
        ];
    }
}
