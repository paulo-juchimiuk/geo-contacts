<?php

declare(strict_types=1);

namespace Modules\Contact\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Contact\Domain\Repositories\ContactRepositoryInterface;
use Modules\Contact\Infrastructure\Adapter\Out\Persistence\EloquentContactRepository;

final class ContactServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            ContactRepositoryInterface::class,
            EloquentContactRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}
