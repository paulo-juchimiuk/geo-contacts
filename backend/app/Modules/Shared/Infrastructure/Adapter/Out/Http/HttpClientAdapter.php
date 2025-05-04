<?php

declare(strict_types=1);

namespace App\Modules\Shared\Infrastructure\Adapter\Out\Http;

use Modules\Shared\Domain\Services\HttpClientInterface;
use Illuminate\Support\Facades\Http;

class HttpClientAdapter implements HttpClientInterface
{
    public function get(string $url, array $params = []): array
    {
        return Http::get($url, $params)->json();
    }
}
