<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Listings;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AdminListingControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_requires_admin_role(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        Sanctum::actingAs($user);

        $this->getJson('/api/admin/listings')
            ->assertForbidden()
            ->assertJsonPath('message', 'Forbidden. Admin access required.');
    }

    public function test_admin_can_approve_pending_listing(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Sanctum::actingAs($admin);

        $listing = Listings::create([
            'user_id' => User::factory()->create()->id,
            'car_id' => Car::create($this->validCarPayload())->id,
            'price' => 5200000,
            'horsepower' => 150,
            'status' => 'pending',
        ]);

        $this->patchJson("/api/admin/listings/{$listing->id}/approve")
            ->assertOk()
            ->assertJsonPath('data.status', 'active');

        $this->assertDatabaseHas('listings', [
            'id' => $listing->id,
            'status' => 'active',
        ]);
    }

    private function validCarPayload(): array
    {
        return [
            'brand' => 'Ford',
            'model' => 'Focus',
            'color' => 'Silver',
            'description' => 'Admin listing teszt auto',
            'year' => 2020,
            'mileage' => 60000,
            'fuel_type' => 'diesel',
            'transmission' => 'manual',
            'engine_size' => 2000,
            'body_type' => 'wagon',
        ];
    }
}