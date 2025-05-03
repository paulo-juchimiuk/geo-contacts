<?php

declare(strict_types=1);

namespace App\Modules\Contact\Infrastructure\Adapter\In\Http\Responses;

use Illuminate\Http\JsonResponse;

class APIResponse
{
    public static function success(int $code, string $message, mixed $details = []): JsonResponse
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'details' => $details,
        ], $code);
    }

    public static function error(int $code, string $message, mixed $details = []): JsonResponse
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'details' => $details,
        ], $code);
    }
}
