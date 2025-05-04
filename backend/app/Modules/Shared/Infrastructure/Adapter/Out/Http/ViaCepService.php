<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Adapter\Out\Http;

use Modules\Shared\Domain\Services\ViaCepGatewayInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ViaCepService implements ViaCepGatewayInterface
{
    public function lookup(string $cep): array
    {
        return Cache::remember("cep:$cep", now()->addMinutes(5), function () use ($cep) {
            $response = Http::get(config('services.viacep.url') . "/{$cep}/json/");

            if ($response->failed() || $response->json('erro')) {
                throw new \RuntimeException('CEP não encontrado ou inválido');
            }

            return $response->json();
        });
    }
}
