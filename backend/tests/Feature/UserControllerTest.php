<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Listings;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_returns_user_by_id(): void
    {
        $user = User::factory()->create();

        $this->getJson("/api/users/{$user->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $user->id)
            ->assertJsonPath('data.email', $user->email);
    }

    public function test_me_returns_authenticated_user_with_listings(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        Listings::create([
            'user_id' => $user->id,
            'car_id' => Car::create($this->validCarPayload())->id,
            'price' => 3100000,
            'horsepower' => 95,
            'status' => 'active',
        ]);

        $this->getJson('/api/users/me')
            ->assertOk()
            ->assertJsonPath('data.user.id', $user->id)
            ->assertJsonCount(1, 'data.listings');
    }

    private function validCarPayload(): array
    {
        return [
            'brand' => 'Suzuki',
            'model' => 'Swift',
            'color' => 'Red',
            'description' => 'User controller teszt auto',
            'year' => 2018,
            'mileage' => 84000,
            'fuel_type' => 'benzin',
            'transmission' => 'manual',
            'engine_size' => 1200,
            'body_type' => 'hatchback',
        ];
    }
}
