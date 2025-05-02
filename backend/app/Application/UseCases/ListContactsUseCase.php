<?php

declare(strict_types=1);

namespace App\Application\UseCases;

use App\Domain\Entities\Contact;
use App\Domain\Repositories\ContactRepositoryInterface;

readonly class ListContactsUseCase
{
    public function __construct(
        private ContactRepositoryInterface $contactRepository
    ) {}

    /**
     * @return Contact[]
     */
    public function execute(int $userId, ?string $query = null): array
    {
        return $this->contactRepository->search($userId, $query);
    }
}
