<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Carimage;
use App\Models\Listings;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::firstOrCreate([
            'email' => 'test@example.com',
        ], [
            'name' => 'Test User',
            'phone' => '+36201234567',
            'password' => bcrypt('password'),
        ]);

        $examples = [
            [
                'car' => [
                    'brand' => 'Opel',
                    'model' => 'H-Astra Tourer',
                    'color' => 'Szürke',
                    'description' => 'Megkímélt, szervizelt autó, családi használatra kiváló állapotban.',
                    'year' => 2006,
                    'mileage' => 142000,
                    'fuel_type' => 'Benzin',
                    'transmission' => 'Manuális',
                    'engine_size' => 1600,
                    'body_type' => 'Kombi',
                ],
                'listing' => [
                    'price' => 1,
                    'status' => 'active',
                ],
                'photos' => [

                ],
            ],
            [
                'car' => [
                    'brand' => 'Volkswagen',
                    'model' => 'Golf 7 GTE',
                    'color' => 'Kék',
                    'description' => 'Alacsony fogyasztású, megbízható hibrid modell, városi és országúti használatra is.',
                    'year' => 2015,
                    'mileage' => 210000,
                    'fuel_type' => 'Hibrid',
                    'transmission' => 'Automata',
                    'engine_size' => 1400,
                    'body_type' => 'Ferdehátú',
                ],
                'listing' => [
                    'price' => 1,
                    'status' => 'active',
                ],
                'photos' => [

                ],
            ],
            [
                'car' => [
                    'brand' => 'Audi',
                    'model' => 'A3 2.0 TDI',
                    'color' => 'Fehér',
                    'description' => 'Magas felszereltség, kényelmes belső tér, rendszeresen karbantartott állapot.',
                    'year' => 2013,
                    'mileage' => 210000,
                    'fuel_type' => 'Dízel',
                    'transmission' => 'Manuális',
                    'engine_size' => 2000,
                    'body_type' => 'Ferdehátú',
                ],
                'listing' => [
                    'price' => 6700000,
                    'status' => 'active',
                ],
                'photos' => [
                    'https://i.imgur.com/1zLXiIU.jpeg',
                    'https://i.imgur.com/IMpbgQY.jpeg',
                    'https://i.imgur.com/CF5Ss2T.jpeg',
                ],
            ],

            [
                'car' => [
                    'brand' => 'Volkswagen',
                    'model' => 'Jetta',
                    'color' => 'Ezüst',
                    'description' => 'A Volkswagen Jetta (A6) egy kompakt autó, a Volkswagen Jetta hatodik generációja és a Jetta (A5) utódja. Fejlesztése során NCS (New Compact Sedan) néven ismert modell 2010-ben jelent meg.',
                    'year' => 2013,
                    'mileage' => 200000,
                    'fuel_type' => 'Benzin',
                    'transmission' => 'Manuális',
                    'engine_size' => 1200,
                    'body_type' => 'Sedán',
                ],
                'listing' => [
                    'price' => 4200000,
                    'status' => 'active',
                ],
                'photos' => [
                    'https://i.imgur.com/JtnJoLj.jpeg',
                    'https://i.imgur.com/yuaaIMU.jpeg',
                    'https://i.imgur.com/qFA1afc.jpeg',
                ],
            ],

            [
                'car' => [
                    'brand' => 'Opel',
                    'model' => 'J-Astra GTC',
                    'color' => 'Sárga',
                    'description' => 'Egy sportos, háromajtós kompakt autó az Opel kínálatában. Dinamikus dizájn, feszesebb futómű és turbós motorok jellemzik, így a praktikum mellé élvezetes vezetést is ad.',
                    'year' => 2012,
                    'mileage' => 337000,
                    'fuel_type' => 'Dízel',
                    'transmission' => 'Manuális',
                    'engine_size' => 2000,
                    'body_type' => 'Ferdehátú',
                ],
                'listing' => [
                    'price' => 2670000,
                    'status' => 'active',
                ],
                'photos' => [
                    'https://i.imgur.com/YFs9RTR.jpeg',
                    'https://i.imgur.com/ryyVYO5.jpeg',
                    'https://i.imgur.com/nJsVS5d.jpeg',
                ],
            ],
        ];

        foreach ($examples as $index => $example) {
            $car = Car::create($example['car']);

            $listing = Listings::create([
                'user_id' => $user->id,
                'car_id' => $car->id,
                'price' => $example['listing']['price'],
                'status' => $example['listing']['status'],
            ]);

            foreach ($example['photos'] as $photoIndex => $photoUrl) {
                $response = Http::timeout(20)->get($photoUrl);

                if (!$response->successful()) {
                    continue;
                }

                $contentType = strtolower((string) $response->header('Content-Type', 'image/jpeg'));
                $extension = str_contains($contentType, 'png') ? 'png' : 'jpg';
                $fileName = "cars/seed-listing-{$listing->id}-{$photoIndex}.{$extension}";

                Storage::disk('public')->put($fileName, $response->body());

                Carimage::create([
                    'car_id' => $car->id,
                    'image_url' => Storage::disk('public')->url($fileName),
                ]);
            }
        }
    }
}