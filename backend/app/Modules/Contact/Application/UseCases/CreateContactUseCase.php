<?php

declare(strict_types=1);

namespace Modules\Contact\Application\UseCases;

use Modules\Contact\Domain\Entities\Contact as DomainContact;
use Modules\Contact\Domain\Repositories\ContactRepositoryInterface;
use Modules\Contact\Domain\ValueObjects\CPF;
use Modules\Shared\Domain\Services\GoogleGeocodeGatewayInterface;

readonly class CreateContactUseCase
{
    public function __construct(
        private ContactRepositoryInterface $contactRepository,
        private GoogleGeocodeGatewayInterface $geocodeGateway
    ) {}

    public function execute(
        int $userId,
        string $name,
        string $cpf,
        string $phone,
        string $address,
        ?float $latitude = null,
        ?float $longitude = null
    ): DomainContact {
        if ($this->contactRepository->findByCpf($cpf, $userId)) {
            throw new \DomainException('ContactModel with this CPF already exists.');
        }

        if ($latitude === null || $longitude === null) {
            $location = $this->geocodeGateway->geocode($address);
            $latitude = $location['lat'];
            $longitude = $location['lng'];
        }

        $contact = new DomainContact(
            id: null,
            userId: $userId,
            name: $name,
            cpf: new CPF($cpf),
            phone: $phone,
            address: $address,
            latitude: $latitude,
            longitude: $longitude
        );

        return $this->contactRepository->save($contact);
    }
}
