<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Adapter\Out\Http;

use Modules\Shared\Domain\Services\ViaCepGatewayInterface;
use Modules\Shared\Domain\Services\HttpClientInterface;
use Illuminate\Support\Facades\Cache;
use RuntimeException;

final readonly class ViaCepService implements ViaCepGatewayInterface
{
    public function __construct(
        private HttpClientInterface $http,
        private string $baseUrl
    ) {}

    public function lookup(string $cep): array
    {
        return Cache::remember("cep:$cep", now()->addMinutes(5), function () use ($cep) {
            $response = $this->http->get($this->baseUrl . "/{$cep}/json/");

            if (empty($response) || isset($response['erro'])) {
                throw new RuntimeException('CEP não encontrado ou inválido');
            }

            return $response;
        });
    }
}

