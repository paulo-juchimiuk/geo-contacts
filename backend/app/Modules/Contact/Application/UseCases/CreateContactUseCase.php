<?php

declare(strict_types=1);

namespace App\Modules\Contact\Application\UseCases;

use App\Modules\Contact\Domain\Entities\Contact;
use App\Modules\Contact\Domain\Repositories\ContactRepositoryInterface;
use App\Modules\Contact\Domain\ValueObjects\CPF;

readonly class CreateContactUseCase
{
    public function __construct(
        private ContactRepositoryInterface $contactRepository
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
