<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\Contact;
use App\Domain\Repositories\ContactRepositoryInterface;
use App\Domain\ValueObjects\CPF;
use App\Infrastructure\Persistence\EloquentModels\ContactModel;

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

    public function search(int $userId, ?string $query = null): array
    {
        $queryBuilder = ContactModel::query()
            ->where('user_id', $userId)
            ->orderBy('name', 'asc');

        if ($query) {
            $queryBuilder->where(function ($q) use ($query) {
                $q->where('name', 'like', "%$query%")
                    ->orWhere('cpf', 'like', "%$query%");
            });
        }

        $models = $queryBuilder->paginate(10);

        return $models->map(function (ContactModel $model) {
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
        })->toArray();
    }
}
