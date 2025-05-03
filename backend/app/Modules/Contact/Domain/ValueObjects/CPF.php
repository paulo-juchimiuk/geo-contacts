<?php

declare(strict_types=1);

namespace Modules\Contact\Domain\ValueObjects;

use InvalidArgumentException;

final class CPF
{
    private string $cpf;

    public function __construct(string $cpf)
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        if (!$this->isValid($cpf)) {
            throw new InvalidArgumentException('CPF inválido.');
        }

        $this->cpf = $cpf;
    }

    public function __toString(): string
    {
        return $this->formatted();
    }

    public function value(): string
    {
        return $this->cpf;
    }

    public function formatted(): string
    {
        return substr($this->cpf, 0, 3) . '.' .
            substr($this->cpf, 3, 3) . '.' .
            substr($this->cpf, 6, 3) . '-' .
            substr($this->cpf, 9, 2);
    }

    public function equals(CPF $cpf): bool
    {
        return $this->cpf === $cpf->value();
    }

    private function isValid(string $cpf): bool
    {
        if (strlen($cpf) !== 11 || preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += (int) $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }
}
