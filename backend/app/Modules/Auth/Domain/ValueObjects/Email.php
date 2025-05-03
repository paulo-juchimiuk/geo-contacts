<?php

declare(strict_types=1);

namespace Modules\Auth\Domain\ValueObjects;

use InvalidArgumentException;

readonly class Email
{
    public function __construct(private string $value)
    {
        if (! filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid e‑mail');
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }
}
