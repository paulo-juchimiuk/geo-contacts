<?php

declare(strict_types=1);

namespace Modules\Contact\Application\UseCases;

use Modules\Contact\Domain\Entities\Contact;
use Modules\Contact\Domain\Repositories\ContactRepositoryInterface;
use Modules\Contact\Domain\ValueObjects\CPF;

readonly class UpdateContactUseCase
{
    public function __construct(private ContactRepositoryInterface $contacts) {}

    public function execute(
        int $contactId,
        int $userId,
        ?string $name,
        ?string $cpf,
        ?string $phone,
        ?string $address,
        ?float $latitude,
        ?float $longitude,
    ): Contact {
        $contact = $this->contacts->findById($contactId);

        if (!$contact || $contact->getUserId() !== $userId) {
            throw new \DomainException('Contact not found.');
        }

        if ($cpf && $existing = $this->contacts->findByCpf($cpf, $userId)) {
            if ($existing->getId() !== $contactId) {
                throw new \DomainException('Another contact already uses this CPF.');
            }
        }

        $name && $contact->setName($name);
        $cpf && $contact->setCpf(new CPF($cpf));
        $phone && $contact->setPhone($phone);
        $address && $contact->setAddress($address);
        $latitude !== null && $contact->setLatitude($latitude);
        $longitude !== null && $contact->setLongitude($longitude);

        return $this->contacts->save($contact);
    }
}
