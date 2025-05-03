<?php

declare(strict_types=1);

namespace App\Modules\Contact\Domain\Entities;

use App\Modules\Contact\Domain\ValueObjects\CPF;

class Contact
{
    public function __construct(
        private readonly ?int $id,
        private int $userId,
        private string $name,
        private CPF $cpf,
        private string $phone,
        private string $address,
        private ?float $latitude = null,
        private ?float $longitude = null,
    ) {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCpf(): CPF
    {
        return $this->cpf;
    }

    public function setCpf(CPF $cpf): void
    {
        $this->cpf = $cpf;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): void
    {
        $this->latitude = $latitude;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): void
    {
        $this->longitude = $longitude;
    }
}
