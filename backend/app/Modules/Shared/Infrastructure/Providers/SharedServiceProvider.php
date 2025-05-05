<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Providers;

use App\Modules\Shared\Infrastructure\Adapter\Out\Http\HttpClientAdapter;
use Illuminate\Support\ServiceProvider;
use Modules\Shared\Domain\Services\GoogleGeocodeGatewayInterface;
use Modules\Shared\Domain\Services\HttpClientInterface;
use Modules\Shared\Domain\Services\ViaCepGatewayInterface;
use Modules\Shared\Infrastructure\Adapter\Out\Http\GoogleGeocodeService;
use Modules\Shared\Infrastructure\Adapter\Out\Http\ViaCepService;

final class SharedServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ViaCepGatewayInterface::class, function ($app) {
            return new ViaCepService(
                $app->make(HttpClientInterface::class),
                config('services.viacep.url'),
            );
        });

        $this->app->bind(GoogleGeocodeGatewayInterface::class, function ($app) {
            return new GoogleGeocodeService(
                $app->make(HttpClientInterface::class),
                config('services.google.url'),
                env('GOOGLE_MAPS_API_KEY', 'TEST_KEY_FOR_UNIT')
            );
        });

        $this->app->bind(
            HttpClientInterface::class,
            HttpClientAdapter::class
        );
    }
}
