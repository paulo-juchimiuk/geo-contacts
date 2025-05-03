<?php

namespace App\Providers;

use App\Modules\Contact\Domain\Repositories\ContactRepositoryInterface;
use App\Modules\Contact\Infrastructure\Adapter\Out\Persistence\EloquentContactRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ContactRepositoryInterface::class, EloquentContactRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
