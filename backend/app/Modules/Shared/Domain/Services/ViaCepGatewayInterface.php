<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\Services;

interface ViaCepGatewayInterface
{
    public function lookup(string $cep): array;
}
