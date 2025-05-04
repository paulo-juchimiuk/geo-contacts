<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Adapter\In\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Shared\Domain\Services\ViaCepGatewayInterface;
use Modules\Shared\Infrastructure\Adapter\In\Http\Requests\LookupCepRequest;

class ViaCepController extends Controller
{
    public function __invoke(LookupCepRequest $request, ViaCepGatewayInterface $viaCep): JsonResponse
    {
        $cep = $request->validated('cep');

        try {
            $address = $viaCep->lookup($cep);

            return response()->json([
                'code' => 200,
                'message' => 'Endereço encontrado',
                'details' => $address,
            ]);
        } catch (\RuntimeException $e) {
            return response()->json([
                'code' => 404,
                'message' => $e->getMessage(),
                'details' => [],
            ], 404);
        }
    }
}
