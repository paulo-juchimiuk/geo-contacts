<?php

declare(strict_types=1);

namespace Modules\Contact\Infrastructure\Adapter\Out\Persistence;

use Modules\Contact\Domain\Entities\Contact;
use Modules\Contact\Domain\Repositories\ContactRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Contact\Domain\ValueObjects\CPF;
use Modules\Contact\Infrastructure\Adapter\Out\Persistence\EloquentModels\ContactModel as ContactModel;

class EloquentContactRepository implements ContactRepositoryInterface
{
    public function save(Contact $contact): Contact
    {
        $model = ContactModel::updateOrCreate(
            ['id' => $contact->getId()],
            [
                'user_id' => $contact->getUserId(),
                'name' => $contact->getName(),
                'cpf' => (string) $contact->getCpf(),
                'phone' => $contact->getPhone(),
                'address' => $contact->getAddress(),
                'latitude' => $contact->getLatitude(),
                'longitude' => $contact->getLongitude(),
            ]
        );

        return new Contact(
            id: $model->id,
            userId: $model->user_id,
            name: $model->name,
            cpf: new CPF($model->cpf),
            phone: $model->phone,
            address: $model->address,
            latitude: $model->latitude !== null ? (float) $model->latitude : null,
            longitude: $model->longitude !== null ? (float) $model->longitude : null,
        );
    }

    public function findById(int $id): ?Contact
    {
        $model = ContactModel::find($id);

        if (!$model) {
            return null;
        }

        return new Contact(
            id: $model->id,
            userId: $model->user_id,
            name: $model->name,
            cpf: new CPF($model->cpf),
            phone: $model->phone,
            address: $model->address,
            latitude: $model->latitude !== null ? (float) $model->latitude : null,
            longitude: $model->longitude !== null ? (float) $model->longitude : null,
        );
    }

    public function findByCpf(string $cpf, int $userId): ?Contact
    {
        $model = ContactModel::where('cpf', $cpf)
            ->where('user_id', $userId)
            ->first();

        if (!$model) {
            return null;
        }

        return new Contact(
            id: $model->id,
            userId: $model->user_id,
            name: $model->name,
            cpf: new CPF($model->cpf),
            phone: $model->phone,
            address: $model->address,
            latitude: $model->latitude !== null ? (float) $model->latitude : null,
            longitude: $model->longitude !== null ? (float) $model->longitude : null,
        );
    }

    public function delete(Contact $contact): void
    {
        ContactModel::where('id', $contact->getId())->delete();
    }

    public function paginate(
        int $userId,
        ?string $query = null,
        string $sortBy = 'name',
        string $dir = 'asc', int
        $perPage = 10
    ): LengthAwarePaginator
    {
        $qb = ContactModel::query()
            ->where('user_id', $userId)
            ->orderBy($sortBy, $dir);

        if ($query) {
            $qb->where(fn ($q) =>
            $q->where('name', 'like', "%{$query}%")
                ->orWhere('cpf',  'like', "%{$query}%")
            );
        }

        return $qb->paginate($perPage);
    }
}
