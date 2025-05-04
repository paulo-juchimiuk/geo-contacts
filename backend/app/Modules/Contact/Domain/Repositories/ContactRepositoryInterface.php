<?php

declare(strict_types=1);

namespace Modules\Contact\Domain\Repositories;

use Modules\Contact\Domain\Entities\Contact;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ContactRepositoryInterface
{
    public function save(Contact $contact): Contact;
    public function findById(int $id): ?Contact;
    public function findByCpf(string $cpf, int $userId): ?Contact;
    public function delete(Contact $contact): void;
    public function paginate(
        int $userId,
        ?string $query = null,
        string $sortBy = 'name',
        string $dir = 'asc',
        int $perPage = 10
    ): LengthAwarePaginator;
}
