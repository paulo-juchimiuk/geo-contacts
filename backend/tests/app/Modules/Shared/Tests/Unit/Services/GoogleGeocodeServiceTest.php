<?php

declare(strict_types=1);

namespace Tests\app\Modules\Shared\Tests\Unit\Services;

use Modules\Shared\Domain\Services\HttpClientInterface;
use Modules\Shared\Infrastructure\Adapter\Out\Http\GoogleGeocodeService;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class GoogleGeocodeServiceTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test_geocode_returns_coordinates(): void
    {
        $http = $this->createMock(HttpClientInterface::class);
        $http->method('get')->willReturn([
            'results' => [
                ['geometry' => ['location' => ['lat' => -23.55052, 'lng' => -46.633308]]],
            ],
        ]);

        $service = new GoogleGeocodeService($http, 'https://maps.googleapis.com/maps/api/geocode/json', 'fake-key');

        $result = $service->geocode('Praça da Sé, São Paulo');

        $this->assertEquals(-23.55052, $result['lat']);
        $this->assertEquals(-46.633308, $result['lng']);
    }

    /**
     * @throws Exception
     */
    public function test_geocode_invalid_address_throws_exception(): void
    {
        $http = $this->createMock(HttpClientInterface::class);
        $http->method('get')->willReturn(['results' => []]);

        $service = new GoogleGeocodeService($http, 'https://maps.googleapis.com/maps/api/geocode/json', 'fake-key');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Endereço não encontrado');

        $service->geocode('Endereço inexistente');
    }
}
