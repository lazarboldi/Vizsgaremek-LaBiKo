<?php

namespace Tests\Feature;

use App\Models\Car;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_creates_a_car(): void
    {
        $response = $this->postJson('/api/cars', $this->validCarPayload());

        $response
            ->assertCreated()
            ->assertJsonPath('data.brand', 'Toyota')
            ->assertJsonPath('data.model', 'Corolla');

        $this->assertDatabaseHas('cars', [
            'brand' => 'Toyota',
            'model' => 'Corolla',
        ]);
    }

    public function test_update_is_forbidden_by_request_authorization(): void
    {
        $car = Car::create($this->validCarPayload());

        $this->patchJson("/api/cars/{$car->id}", [
            'brand' => 'Honda',
        ])->assertForbidden();
    }

    private function validCarPayload(): array
    {
        return [
            'brand' => 'Toyota',
            'model' => 'Corolla',
            'color' => 'Blue',
            'description' => 'Megkimelt allapotu auto',
            'year' => 2022,
            'mileage' => 25000,
            'fuel_type' => 'benzin',
            'transmission' => 'manual',
            'engine_size' => 1600,
            'body_type' => 'sedan',
        ];
    }
}
