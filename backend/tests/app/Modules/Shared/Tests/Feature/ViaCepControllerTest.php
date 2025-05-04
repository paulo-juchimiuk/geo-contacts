<?php

declare(strict_types=1);

namespace Tests\app\Modules\Shared\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Modules\Auth\Infrastructure\Adapter\Out\Persistence\EloquentModels\UserModel;
use Tests\TestCase;

class ViaCepControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_lookup_valid_cep(): void
    {
        $url = config('services.viacep.url') . '/01001000/json/';

        Http::fake([
            $url => Http::response([
                'cep' => '01001000',
                'logradouro' => 'Praça da Sé',
            ], 200),
        ]);

        $user = UserModel::factory()->create();

        $this->actingAs($user)
            ->getJson('/api/cep/01001000')
            ->assertOk()
            ->assertJson([
                'code' => 200,
                'message' => 'Endereço encontrado',
                'details' => [
                    'cep' => '01001000',
                    'logradouro' => 'Praça da Sé',
                ],
            ]);
    }

    public function test_user_cannot_lookup_invalid_cep(): void
    {
        $url = config('services.viacep.url') . '/00000000/json/';

        Http::fake([
            $url => Http::response(['erro' => true], 200),
        ]);

        $user = UserModel::factory()->create();

        $this->actingAs($user)
            ->getJson('/api/cep/00000000')
            ->assertStatus(404)
            ->assertJson([
                'code' => 404,
                'message' => 'CEP não encontrado ou inválido',
            ]);
    }
}
