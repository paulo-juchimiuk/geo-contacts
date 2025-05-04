<?php

declare(strict_types=1);

namespace Modules\Auth\Infrastructure\Adapter\In\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Modules\Auth\Application\UseCases\DeleteAccountUseCase;

readonly class AccountController
{
    public function __construct(private DeleteAccountUseCase $deleteAccount) {}

    /**
     * @throws ValidationException
     */
    public function destroy(Request $request): JsonResponse
    {
        $request->validate(['password' => ['required','string']]);

        $userModel = $request->user();

        if (! Hash::check($request->string('password'), $userModel->password)) {
            throw ValidationException::withMessages(['password' => 'Senha incorreta']);
        }

        ($this->deleteAccount)($userModel->toDomain());

        return response()->json([
            'code'    => 204,
            'message' => 'Account deleted',
            'details' => null,
        ], 204);
    }
}
