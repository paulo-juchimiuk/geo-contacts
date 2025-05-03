<?php

declare(strict_types=1);

namespace Tests\Unit\App\Domain\ValueObjects;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Modules\Contact\Domain\ValueObjects\CPF;

class CPFTest extends TestCase
{
    public function test_can_create_valid_cpf(): void
    {
        $cpf = new CPF('529.982.247-25');

        $this->assertEquals('529.982.247-25', (string) $cpf);
        $this->assertEquals('529.982.247-25', $cpf->formatted());
        $this->assertEquals('52998224725', $cpf->value());
    }

    public function test_can_compare_cpfs(): void
    {
        $cpf1 = new CPF('529.982.247-25');
        $cpf2 = new CPF('52998224725');

        $this->assertTrue($cpf1->equals($cpf2));
    }

    public function test_invalid_cpf_throws_exception(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new CPF('111.111.111-11');
    }
}
