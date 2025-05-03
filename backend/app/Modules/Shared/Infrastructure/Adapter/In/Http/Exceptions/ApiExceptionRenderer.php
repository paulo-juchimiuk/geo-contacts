<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Adapter\In\Http\Exceptions;

use DomainException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;
use Illuminate\Http\JsonResponse;

class ApiExceptionRenderer
{
    public static function render(Throwable $e): JsonResponse
    {
        if ($e instanceof ValidationException) {
            return response()->json([
                'code' => 422,
                'message' => 'Validation failed',
                'details' => $e->errors(),
            ], 422)->header('Content-Type', 'application/json');
        }

        if ($e instanceof DomainException) {
            return response()->json([
                'code' => 422,
                'message' => $e->getMessage(),
                'details' => [],
            ], 422)->header('Content-Type', 'application/json');
        }

        if ($e instanceof HttpException) {
            return response()->json([
                'code' => $e->getStatusCode(),
                'message' => $e->getMessage(),
                'details' => [],
            ], $e->getStatusCode())->header('Content-Type', 'application/json');
        }

        return response()->json([
            'code' => 500,
            'message' => 'Internal Server Error',
            'details' => [],
        ], 500)->header('Content-Type', 'application/json');
    }
}
