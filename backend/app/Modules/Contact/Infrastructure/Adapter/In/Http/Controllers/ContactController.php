<?php

declare(strict_types=1);

namespace Modules\Contact\Infrastructure\Adapter\In\Http\Controllers;

use Modules\Contact\Application\UseCases\CreateContactUseCase;
use Modules\Contact\Application\UseCases\ListContactsUseCase;
use Modules\Contact\Infrastructure\Adapter\In\Http\Requests\ListContactsRequest;
use Modules\Contact\Infrastructure\Adapter\In\Http\Requests\StoreContactRequest;
use Modules\Contact\Infrastructure\Adapter\In\Http\Responses\APIResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

readonly class ContactController
{
    public function __construct(
        private CreateContactUseCase $createContactUseCase
    ) {}

    public function store(StoreContactRequest $request): JsonResponse
    {
        $user = Auth::user();

        $contact = $this->createContactUseCase->execute(
            userId: $user->id,
            name: $request->string('name')->toString(),
            cpf: $request->string('cpf')->toString(),
            phone: $request->string('phone')->toString(),
            address: $request->string('address')->toString(),
            latitude: $request->float('latitude'),
            longitude: $request->float('longitude'),
        );

        return APIResponse::success(201, 'ContactModel created successfully', [
            'id' => $contact->getId(),
            'name' => $contact->getName(),
            'cpf' => (string) $contact->getCpf(),
            'phone' => $contact->getPhone(),
            'address' => $contact->getAddress(),
            'latitude' => $contact->getLatitude(),
            'longitude' => $contact->getLongitude(),
        ]);
    }

    public function index(ListContactsRequest $request, ListContactsUseCase $useCase): JsonResponse
    {
        $user = Auth::user();

        $contacts = $useCase->execute(
            userId: $user->id,
            query: $request->string('q')->toString()
        );

        return APIResponse::success(200, 'Contacts fetched successfully', $contacts);
    }
}
