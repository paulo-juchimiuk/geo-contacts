<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Adapter\Out\Http;

use Modules\Shared\Domain\Services\GoogleGeocodeGatewayInterface;
use Modules\Shared\Domain\Services\HttpClientInterface;
use RuntimeException;

final readonly class GoogleGeocodeService implements GoogleGeocodeGatewayInterface
{
    public function __construct(
        private HttpClientInterface $http,
        private string $baseUrl,
        private string $apiKey
    ) {}

    public function geocode(string $address): array
    {
        $response = $this->http->get($this->baseUrl, [
            'address' => $address,
            'key' => $this->apiKey,
        ]);

        if (empty($response['results'])) {
            throw new RuntimeException('Endereço não encontrado');
        }

        return $response['results'][0]['geometry']['location'];
    }
}

