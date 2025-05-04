<?php

declare(strict_types=1);

namespace Modules\Contact\Application\UseCases;

use Modules\Contact\Domain\Repositories\ContactRepositoryInterface;

readonly class ListContactsUseCase
{
    public function __construct(
        private ContactRepositoryInterface $contactRepository
    ) {}

    public function execute(int $userId, ?string $query = null): array
    {
        return $this->contactRepository->search($userId, $query);
    }
}
