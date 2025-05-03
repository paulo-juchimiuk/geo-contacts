<?php

declare(strict_types=1);

namespace Modules\Auth\Infrastructure\Adapter\In\Http\Controllers;

use App\Modules\Auth\Application\UseCases\RegisterUserUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

readonly class RegisteredUserController
{
    public function __construct(private RegisterUserUseCase $registerUser) {}

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|confirmed|min:8',
        ]);

        $output = ($this->registerUser)(
            $data['name'], $data['email'], $data['password']
        );

        return response()->json([
            'code'    => 201,
            'message' => 'User registered successfully',
            'details' => $output,
        ], 201);
    }
}
