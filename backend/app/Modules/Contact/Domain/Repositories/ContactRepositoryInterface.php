<?php

declare(strict_types=1);

namespace Modules\Contact\Domain\Repositories;

use Modules\Contact\Domain\Entities\Contact;

interface ContactRepositoryInterface
{
    public function save(Contact $contact): Contact;
    public function findById(int $id): ?Contact;
    public function findByCpf(string $cpf, int $userId): ?Contact;
    public function delete(Contact $contact): void;
    public function search(int $userId, ?string $query = null): array;
}
