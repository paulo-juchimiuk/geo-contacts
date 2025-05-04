<?php

declare(strict_types=1);

namespace Modules\Contact\Application\UseCases;

use Modules\Contact\Domain\Repositories\ContactRepositoryInterface;

readonly class DeleteContactUseCase
{
    public function __construct(private ContactRepositoryInterface $contacts) {}

    public function execute(int $contactId, int $userId): void
    {
        $contact = $this->contacts->findById($contactId);

        if (!$contact || $contact->getUserId() !== $userId) {
            throw new \DomainException('Contact not found.');
        }

        $this->contacts->delete($contact);
    }
}
