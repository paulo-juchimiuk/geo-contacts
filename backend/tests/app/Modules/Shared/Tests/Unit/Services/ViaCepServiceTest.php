<?php

declare(strict_types=1);

namespace Tests\app\Modules\Shared\Tests\Unit\Services;

use Modules\Shared\Domain\Services\HttpClientInterface;
use Modules\Shared\Infrastructure\Adapter\Out\Http\ViaCepService;
use PHPUnit\Framework\MockObject\Exception;
use Illuminate\Support\Facades\Cache;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class ViaCepServiceTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test_lookup_valid_cep_returns_address(): void
    {
        $cep = '01001000';

        $http = $this->createMock(HttpClientInterface::class);
        $http->method('get')->willReturn([
            'cep' => $cep,
            'logradouro' => 'Praça da Sé',
        ]);

        Cache::shouldReceive('remember')
            ->andReturnUsing(fn ($key, $ttl, $callback) => $callback());

        $service = new ViaCepService($http, 'https://viacep.com.br/ws');

        $result = $service->lookup($cep);

        $this->assertEquals($cep, $result['cep']);
        $this->assertEquals('Praça da Sé', $result['logradouro']);
    }

    /**
     * @throws Exception
     */
    public function test_lookup_invalid_cep_throws_exception(): void
    {
        $cep = '00000000';

        $http = $this->createMock(HttpClientInterface::class);
        $http->method('get')->willReturn(['erro' => true]);

        Cache::shouldReceive('remember')
            ->andReturnUsing(fn ($key, $ttl, $callback) => $callback());

        $service = new ViaCepService($http, 'https://viacep.com.br/ws');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('CEP não encontrado ou inválido');

        $service->lookup($cep);
    }
}
