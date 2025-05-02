<?php

declare(strict_types=1);

namespace App\Application\UseCases;

use App\Domain\Entities\Contact;
use App\Domain\Repositories\ContactRepositoryInterface;
use App\Domain\ValueObjects\CPF;

class CreateContactUseCase
{
    public function __construct(
        private readonly ContactRepositoryInterface $contactRepository
    ) {}

    public function execute(
        int $userId,
        string $name,
        string $cpf,
        string $phone,
        string $address,
        ?float $latitude = null,
        ?float $longitude = null
    ): Contact {
        if ($this->contactRepository->findByCpf($cpf, $userId)) {
            throw new \DomainException('Contact with this CPF already exists.');
        }

        $contact = new Contact(
            id: null,
            userId: $userId,
            name: $name,
            cpf: new CPF($cpf),
            phone: $phone,
            address: $address,
            latitude: $latitude,
            longitude: $longitude,
        );

        return $this->contactRepository->save($contact);
    }
}
