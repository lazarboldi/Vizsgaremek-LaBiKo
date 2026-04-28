<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Listings;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListingsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_returns_unauthenticated_without_logged_in_user(): void
    {
        $car = Car::create($this->validCarPayload());

        $this->postJson('/api/listings', [
            'car_id' => $car->id,
            'price' => 4500000,
            'horsepower' => 130,
        ])->assertStatus(401)
          ->assertJsonPath('message', 'Unauthenticated.');
    }

    public function test_show_pending_listing_is_forbidden_for_guest(): void
    {
        $listing = Listings::create([
            'user_id' => User::factory()->create()->id,
            'car_id' => Car::create($this->validCarPayload())->id,
            'price' => 3900000,
            'horsepower' => 110,
            'status' => 'pending',
        ]);

        $this->getJson("/api/listings/{$listing->id}")
            ->assertForbidden()
            ->assertJsonPath('message', 'A hirdetés még jóváhagyásra vár.');
    }

    private function validCarPayload(): array
    {
        return [
            'brand' => 'Opel',
            'model' => 'Astra',
            'color' => 'Gray',
            'description' => 'Listings teszt auto',
            'year' => 2019,
            'mileage' => 72000,
            'fuel_type' => 'benzin',
            'transmission' => 'manual',
            'engine_size' => 1600,
            'body_type' => 'hatchback',
        ];
    }
}