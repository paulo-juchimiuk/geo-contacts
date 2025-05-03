<?php

declare(strict_types=1);

namespace Modules\Auth\Infrastructure\Adapter\In\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Modules\Auth\Application\UseCases\LoginUserUseCase;

readonly class AuthenticatedSessionController
{
    public function __construct(private LoginUserUseCase $loginUser) {}

    /**
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email'    => ['required','email'],
            'password' => ['required','string'],
        ]);

        $payload = ($this->loginUser)($data['email'], $data['password']);

        if (! $payload) {
            throw ValidationException::withMessages(['email' => __('auth.failed')]);
        }

        return response()->json([
            'code'    => 200,
            'message' => 'Login successful',
            'details' => $payload,
        ]);
    }

    public function destroy(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'code'    => 204,
            'message' => 'Logout successful',
            'details' => null,
        ], 204);
    }
}
