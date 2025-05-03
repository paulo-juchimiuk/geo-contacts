<?php

declare(strict_types=1);

namespace Modules\Auth\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;
use Modules\Auth\Infrastructure\Adapter\Out\Persistence\EloquentUserRepository;

final class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
    }
}
