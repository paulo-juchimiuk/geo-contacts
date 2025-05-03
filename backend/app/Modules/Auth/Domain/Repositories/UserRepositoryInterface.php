<?php

declare(strict_types=1);

namespace Modules\Auth\Domain\Repositories;

use Modules\Auth\Domain\Entities\User;
use Modules\Auth\Domain\ValueObjects\Email;

interface UserRepositoryInterface
{
    public function save(User $user): User;
    public function findByEmail(Email $email): ?User;
    public function createApiToken(User $user): string;
}
