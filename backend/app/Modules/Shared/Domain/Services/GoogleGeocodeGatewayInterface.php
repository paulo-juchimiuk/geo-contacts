<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\Services;

interface GoogleGeocodeGatewayInterface
{
    public function geocode(string $address): array;
}
