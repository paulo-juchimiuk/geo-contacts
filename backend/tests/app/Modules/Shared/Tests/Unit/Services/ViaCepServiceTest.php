<?php

declare(strict_types=1);

namespace Tests\app\Modules\Shared\Tests\Unit\Services;

use Modules\Shared\Infrastructure\Adapter\Out\Http\ViaCepService;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ViaCepServiceTest extends TestCase
{
    public function test_lookup_valid_cep_returns_address(): void
    {
        $cep = '01001000';

        Http::fake([
            "https://viacep.com.br/ws/{$cep}/json/" => Http::response([
                'cep' => $cep,
                'logradouro' => 'Praça da Sé',
            ], 200),
        ]);

        Cache::shouldReceive('remember')
            ->andReturnUsing(fn ($key, $ttl, $callback) => $callback());

        $service = new ViaCepService();

        $result = $service->lookup($cep);

        $this->assertEquals($cep, $result['cep']);
        $this->assertEquals('Praça da Sé', $result['logradouro']);
    }

    public function test_lookup_invalid_cep_throws_exception(): void
    {
        $cep = '00000000';

        Http::fake([
            "https://viacep.com.br/ws/{$cep}/json/" => Http::response(['erro' => true], 200),
        ]);

        Cache::shouldReceive('remember')
            ->andReturnUsing(fn ($key, $ttl, $callback) => $callback());

        $service = new ViaCepService();

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('CEP não encontrado ou inválido');

        $service->lookup($cep);
    }
}
