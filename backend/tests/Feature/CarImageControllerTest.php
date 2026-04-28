<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Carimage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CarimageControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_uploads_image_and_creates_record(): void
    {
        Storage::fake('public');
        $car = Car::create($this->validCarPayload());

        $response = $this->post('/api/carimages', [
            'car_id' => $car->id,
            'image' => UploadedFile::fake()->image('car.jpg'),
        ]);

        $response
            ->assertCreated()
            ->assertJsonPath('car_id', $car->id);

        $this->assertDatabaseCount('carimages', 1);
    }

    public function test_destroy_deletes_carimage_record(): void
    {
        $car = Car::create($this->validCarPayload());

        $carimage = Carimage::create([
            'car_id' => $car->id,
            'image_url' => 'http://localhost/storage/cars/existing.jpg',
        ]);

        $this->deleteJson("/api/carimages/{$carimage->car_imageid}")
            ->assertNoContent();

        $this->assertDatabaseMissing('carimages', [
            'car_imageid' => $carimage->car_imageid,
        ]);
    }

    private function validCarPayload(): array
    {
        return [
            'brand' => 'Toyota',
            'model' => 'Yaris',
            'color' => 'White',
            'description' => 'Valos tesztauto',
            'year' => 2021,
            'mileage' => 18000,
            'fuel_type' => 'benzin',
            'transmission' => 'manual',
            'engine_size' => 1400,
            'body_type' => 'hatchback',
        ];
    }
}
