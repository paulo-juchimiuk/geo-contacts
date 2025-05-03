<?php

declare(strict_types=1);

namespace Modules\Auth\Infrastructure\Adapter\In\Http\Controllers;

use Modules\Contact\Infrastructure\Adapter\In\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'code' => 200,
                'message' => 'Password reset link sent',
                'details' => ['email' => $request->email],
            ]);
        }

        return response()->json([
            'code' => 400,
            'message' => 'Unable to send password reset link',
            'details' => ['email' => $request->email],
        ], 400);
    }
}
