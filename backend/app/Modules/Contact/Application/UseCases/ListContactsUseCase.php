<?php

declare(strict_types=1);

namespace App\Modules\Contact\Application\UseCases;

use App\Modules\Contact\Domain\Entities\Contact;
use App\Modules\Contact\Domain\Repositories\ContactRepositoryInterface;

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
