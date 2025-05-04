<?php

declare(strict_types=1);

namespace Modules\Contact\Application\UseCases;

use Modules\Contact\Domain\Repositories\ContactRepositoryInterface;
use Modules\Contact\Infrastructure\Adapter\Out\Persistence\EloquentModels\ContactModel;

readonly class ListContactsUseCase
{
    public function __construct(
        private ContactRepositoryInterface $contactRepository
    ) {}

    public function execute(
        int     $userId,
        ?string $query    = null,
                $sortBy   = 'name',
                $dir      = 'asc',
        int     $perPage  = 10
    ): array {
        $page = $this->contactRepository->paginate($userId, $query, $sortBy, $dir, $perPage);

        $page->setCollection(
            $page->getCollection()->map(fn(ContactModel $m) => $m->toDomain())
        );

        return [
            'data' => $page->items(),
            'meta' => [
                'page'      => $page->currentPage(),
                'per_page'  => $page->perPage(),
                'total'     => $page->total(),
                'last_page' => $page->lastPage(),
            ],
        ];
    }
}
