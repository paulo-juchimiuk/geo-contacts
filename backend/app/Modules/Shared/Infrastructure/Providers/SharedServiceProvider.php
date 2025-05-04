<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Shared\Domain\Services\ViaCepGatewayInterface;
use Modules\Shared\Infrastructure\Adapter\Out\Http\ViaCepService;

final class SharedServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            ViaCepGatewayInterface::class,
            ViaCepService::class
        );
    }
}
