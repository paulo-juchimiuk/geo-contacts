<?php

declare(strict_types=1);

namespace App\Exceptions;

use Throwable;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use DomainException;
use RuntimeException;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $e): Response
    {
        if ($e instanceof DomainException || $e instanceof RuntimeException) {
            return response()->json([
                'code'    => 422,
                'message' => 'Validation Error',
                'details' => $e->getMessage(),
            ], 422);
        }
        return parent::render($request, $e);
    }
}
