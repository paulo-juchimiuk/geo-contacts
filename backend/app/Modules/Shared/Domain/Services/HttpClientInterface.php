<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\Services;

interface HttpClientInterface
{
    public function get(string $url, array $params = []): array;
}
