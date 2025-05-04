<?php
declare(strict_types=1);

namespace Tests\app\Modules\Contact\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Infrastructure\Adapter\Out\Persistence\EloquentModels\UserModel;
use Tests\TestCase;

class ContactCrudTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsApi(): array
    {
        $user  = UserModel::factory()->create(['password'=>Hash::make('secret')]);
        $token = $user->createToken('api')->plainTextToken;

        return [$user, $this->withHeader('Authorization',"Bearer {$token}")];
    }

    public function test_user_can_update_and_delete_contact(): void
    {
        [$user, $req] = $this->actingAsApi();

        /* create first */
        $create = $req->postJson('/api/contacts', [
            'name'    => 'Foo',
            'cpf'     => '39053344705',
            'phone'   => '11 9999‑0000',
            'address' => 'Rua A',
        ])->json('details');

        $id = $create['id'];

        /* update */
        $req->putJson("/api/contacts/{$id}", ['phone'=>'11 8888‑7777'])
            ->assertOk()
            ->assertJsonPath('details.phone', '11 8888‑7777');

        $this->assertDatabaseHas('contacts', [
            'id'    => $id,
            'phone' => '11 8888‑7777',
        ]);

        /* delete */
        $req->deleteJson("/api/contacts/{$id}")
            ->assertNoContent();

        $this->assertDatabaseMissing('contacts', ['id'=>$id]);
    }
}
