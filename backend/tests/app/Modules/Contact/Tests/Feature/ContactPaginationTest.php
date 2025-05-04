<?php

namespace Modules\Contact\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Contact\Infrastructure\Adapter\Out\Persistence\EloquentModels\ContactModel;
use Tests\helpers\ActsAsApi;
use Tests\TestCase;

class ContactPaginationTest extends TestCase
{
    use RefreshDatabase, ActsAsApi;

    public function test_user_sees_contacts_page_2(): void
    {
        [$user,$req] = $this->actingAsApi();

        ContactModel::factory()->count(15)->create(['user_id'=>$user->id]);

        $req->getJson('/api/contacts?page=2&per_page=10&sort=name&dir=asc')
            ->assertOk()
            ->assertJsonPath('details.meta.page', 2)
            ->assertJsonCount(5, 'details.data');
    }
}
