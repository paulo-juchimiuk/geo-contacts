<?php

declare(strict_types=1);

namespace Modules\Auth\Infrastructure\Adapter\In\Http\Controllers;

use Modules\Contact\Infrastructure\Adapter\In\Http\Controllers\Controller;
use Modules\Auth\Infrastructure\Adapter\In\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Infrastructure\Adapter\Out\Persistence\EloquentModels\UserModel;

class AuthenticatedSessionController extends Controller
{
    public function store(LoginRequest $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = UserModel::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'code' => 401,
                'message' => 'Invalid credentials',
                'details' => null,
            ], 401);
        }

        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'code' => 200,
            'message' => 'Login successful',
            'details' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'token' => $token,
            ],
        ]);
    }

    public function destroy(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'code' => 200,
            'message' => 'Logout successful',
            'details' => null,
        ]);
    }
}
