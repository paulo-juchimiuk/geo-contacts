<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers;

use App\Application\UseCases\CreateContactUseCase;
use App\Infrastructure\Http\Requests\StoreContactRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ContactController
{
    public function __construct(
        private readonly CreateContactUseCase $createContactUseCase
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

        return response()->json([
            'code' => 201,
            'message' => 'Contact created successfully',
            'details' => [
                'id' => $contact->getId(),
                'name' => $contact->getName(),
                'cpf' => (string) $contact->getCpf(),
                'phone' => $contact->getPhone(),
                'address' => $contact->getAddress(),
                'latitude' => $contact->getLatitude(),
                'longitude' => $contact->getLongitude(),
            ],
        ], 201);
    }
}
