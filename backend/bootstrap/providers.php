<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\RateLimitServiceProvider::class,

    // Domain
    Modules\Auth\Infrastructure\Providers\AuthServiceProvider::class,
    Modules\Contact\Infrastructure\Providers\ContactServiceProvider::class,
    Modules\Shared\Infrastructure\Providers\SharedServiceProvider::class,
];
