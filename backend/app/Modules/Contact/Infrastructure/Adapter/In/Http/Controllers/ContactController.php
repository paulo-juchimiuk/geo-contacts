<?php

declare(strict_types=1);

namespace Modules\Contact\Infrastructure\Adapter\In\Http\Controllers;

use Modules\Contact\Application\UseCases\CreateContactUseCase;
use Modules\Contact\Application\UseCases\DeleteContactUseCase;
use Modules\Contact\Application\UseCases\ListContactsUseCase;
use Modules\Contact\Application\UseCases\UpdateContactUseCase;
use Modules\Contact\Infrastructure\Adapter\In\Http\Requests\ListContactsRequest;
use Modules\Contact\Infrastructure\Adapter\In\Http\Requests\StoreContactRequest;
use Modules\Contact\Infrastructure\Adapter\In\Http\Requests\UpdateContactRequest;
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
            $user->id,
            $request->string('name')->toString(),
            $request->string('cpf')->toString(),
            $request->string('phone')->toString(),
            $request->string('address')->toString(),
            $request->float('latitude'),
            $request->float('longitude'),
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

    public function index(ListContactsRequest $request, ListContactsUseCase $uc): JsonResponse
    {
        $user = Auth::user();

        $res = $uc->execute(
            $user->id,
            $request->string('q')->value(),
            $request->string('sort', 'name')->value(),
            $request->string('dir', 'asc')->value(),
            (int) $request->input('per_page', 10),
        );

        return APIResponse::success(200, 'Contacts fetched', $res);
    }

    public function update(
        int $contact,
        UpdateContactRequest $request,
        UpdateContactUseCase $useCase
    ): JsonResponse {
        $user = Auth::user();

        $payload = $useCase->execute(
            $contact,
            $user->id,
            $request->input('name'),
            $request->input('cpf'),
            $request->input('phone'),
            $request->input('address'),
            $request->input('latitude'),
            $request->input('longitude'),
        );

        return APIResponse::success(200, 'Contact updated', [
            'id' => $payload->getId(),
            'name' => $payload->getName(),
            'cpf' => (string) $payload->getCpf(),
            'phone' => $payload->getPhone(),
            'address' => $payload->getAddress(),
            'latitude' => $payload->getLatitude(),
            'longitude' => $payload->getLongitude(),
        ]);
    }

    public function destroy(
        int $contact,
        DeleteContactUseCase $useCase
    ): JsonResponse {
        $useCase->execute($contact, Auth::id());

        return APIResponse::success(204, 'Contact deleted');
    }
}
