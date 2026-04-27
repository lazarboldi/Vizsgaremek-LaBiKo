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
            'password' => bcrypt('Password1234'),
            'role' => 'user',
        ]);

        User::updateOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin User',
            'phone' => '+36209999999',
            'password' => bcrypt('Admin1234'),
            'role' => 'admin',
        ]);

        $examples = [
            [
                'car' => [
                    'brand' => 'Opel',
                    'model' => 'H-Astra Twinport',
                    'color' => 'Szürke',
                    'description' => 'Megkímélt, szervizelt autó, családi használatra kiváló állapotban.',
                    'year' => 2006,
                    'mileage' => 242536,
                    'fuel_type' => 'Benzin',
                    'transmission' => 'Manuális',
                    'engine_size' => 1598,
                    'body_type' => 'Kombi',
                    'horsepower' => 104,
                ],
                'listing' => [
                    'price' => 1326767,
                    'status' => 'active',
                ],
                'photos' => [
                    'https://i.imgur.com/sfSmfxU.jpeg',
                    'https://i.imgur.com/aEhwzSm.jpeg',
                    'https://i.imgur.com/af6EyKS.jpeg',
                    'https://i.imgur.com/Oprldb6.jpeg',
                ],
            ],
            [
                'car' => [
                    'brand' => 'Volkswagen',
                    'model' => 'Golf 7 GTE',
                    'color' => 'Kék',
                    'description' => 'A Volkswagen Golf Mk7 GTE a Volkswagen sportos plug-in hibrid modellje. A benzinmotor és villanymotor kombinációja erős gyorsulást és alacsony fogyasztást kínál, miközben megőrzi a Golf kényelmét és mindennapi használhatóságát.',
                    'year' => 2015,
                    'mileage' => 210000,
                    'fuel_type' => 'Hibrid',
                    'transmission' => 'Automata',
                    'engine_size' => 1400,
                    'body_type' => 'Ferdehátú',
                    'horsepower' => 204,
                ],
                'listing' => [
                    'price' => 6767670,
                    'status' => 'active',
                ],
                'photos' => [
                    'https://i.imgur.com/5jGNj02.jpeg',
                    'https://i.imgur.com/IhCbIxn.jpeg',
                    'https://i.imgur.com/Z421uiX.jpeg',
                    'https://i.imgur.com/Oprldb6.jpeg',
                ],
            ],
            [
                'car' => [
                    'brand' => 'Audi',
                    'model' => 'A3 8V',
                    'color' => 'Fehér',
                    'description' => 'Az Audi A3 8V 2.0 CR TDI az Audi kompakt modellje, amely erős és takarékos dízelmotorjáról ismert. Kényelmes, jól összerakott belső térrel és stabil vezethetőséggel ideális mindennapi használatra és hosszabb utakra is.',
                    'year' => 2013,
                    'mileage' => 210000,
                    'fuel_type' => 'Dízel',
                    'transmission' => 'Manuális',
                    'engine_size' => 2000,
                    'body_type' => 'Ferdehátú',
                    'horsepower' => 150,
                ],
                'listing' => [
                    'price' => 6700000,
                    'status' => 'active',
                ],
                'photos' => [
                    'https://i.imgur.com/WUXyD2s.jpeg',
                    'https://i.imgur.com/aqcar6E.jpeg',
                    'https://i.imgur.com/GGVpNod.jpeg',
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
                    'horsepower' => 105,
                ],
                'listing' => [
                    'price' => 4200000,
                    'status' => 'active',
                ],
                'photos' => [
                    'https://i.imgur.com/kw4F2LU.jpeg',
                    'https://i.imgur.com/l16oKFk.jpeg',
                    'https://i.imgur.com/EaNxz1m.jpeg',
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
                    'horsepower' => 185,
                ],
                'listing' => [
                    'price' => 2670000,
                    'status' => 'active',
                ],
                'photos' => [
                    'https://i.imgur.com/5CTeJXC.jpeg',
                    'https://i.imgur.com/HhZzTVT.jpeg',
                    'https://i.imgur.com/34nL4yD.jpeg',
                ],
            ],

            [
                'car' => [
                    'brand' => 'Seat',
                    'model' => 'Leon FR',
                    'color' => 'Fehér',
                    'description' => 'A SEAT Leon Mk1 FR 2.0 TFSI a SEAT első generációs Leonjának sportos változata. A 2.0 TFSI turbós benzinmotor erős és jól tuningolható, miközben a feszes futómű és a sportos megjelenés élvezetes vezetést ad.',
                    'year' => 2007,
                    'mileage' => 278000,
                    'fuel_type' => 'Benzin',
                    'transmission' => 'Manuális',
                    'engine_size' => 2000,
                    'body_type' => 'Ferdehátú',
                    'horsepower' => 200,
                ],
                'listing' => [
                    'price' => 2670067,
                    'status' => 'active',
                ],
                'photos' => [
                    'https://i.imgur.com/5h8JYvG.jpeg',
                    'https://i.imgur.com/bxhib32.jpeg',
                ],
            ],

            [
                'car' => [
                    'brand' => 'Volkswagen',
                    'model' => 'Golf GTI',
                    'color' => 'Fekete',
                    'description' => 'A Volkswagen Golf Mk6 GTI a Volkswagen ikonikus sportos kompaktja. A 2.0 TSI turbómotor erős és élvezetes vezetést ad, miközben a GTI megőrzi a mindennapi használhatóságot és a klasszikus sportos stílust.',
                    'year' => 2009,
                    'mileage' => 230000,
                    'fuel_type' => 'Benzin',
                    'transmission' => 'Automata',
                    'engine_size' => 2000,
                    'body_type' => 'Ferdehátú',
                    'horsepower' => 210,
                ],
                'listing' => [
                    'price' => 5555555,
                    'status' => 'active',
                ],
                'photos' => [
                    'https://i.imgur.com/60qKYSi.jpeg',
                    'https://i.imgur.com/ekzTTXh.jpeg',
                    'https://i.imgur.com/ZP0YzPr.jpeg',
                ],
            ],

            [
                'car' => [
                    'brand' => 'Volvo',
                    'model' => 'C30 R-Line',
                    'color' => 'Fehér',
                    'description' => 'A Volvo C30 T5 a Volvo Cars egyik legizgalmasabb kompakt modellje. Az 5 hengeres turbós benzinmotor erős, jellegzetes hangú és élvezetes vezetést ad, miközben a C30 különleges, sportos formája igazán egyedivé teszi.',
                    'year' => 2013,
                    'mileage' => 210000,
                    'fuel_type' => 'Dízel',
                    'transmission' => 'Automata',
                    'engine_size' => 2400,
                    'body_type' => 'Ferdehátú',
                    'horsepower' => 184,
                ],
                'listing' => [
                    'price' => 6969690,
                    'status' => 'active',
                ],
                'photos' => [
                    'https://i.imgur.com/fNISUdM.jpeg',
                    'https://i.imgur.com/w45paMJ.jpeg',
                    'https://i.imgur.com/hP9Sioq.jpeg',
                ],
            ],

            [
                'car' => [
                    'brand' => 'Volkswagen',
                    'model' => 'Golf 7 R-Line',
                    'color' => 'Fehér',
                    'description' => 'A Volkswagen Golf Mk7 1.4 TSI 150 R-Line a Volkswagen egyik népszerű kompaktja. Az 1.4 TSI 150 lóerős turbómotor dinamikus, mégis takarékos, az R-Line csomag pedig sportos külsőt és hangulatot ad a mindennapi használhatóság mellé.',
                    'year' => 2014,
                    'mileage' => 174000,
                    'fuel_type' => 'Benzin',
                    'transmission' => 'Manuális',
                    'engine_size' => 1400,
                    'body_type' => 'Ferdehátú',
                    'horsepower' => 150,
                ],
                'listing' => [
                    'price' => 4131313,
                    'status' => 'active',
                ],
                'photos' => [
                    'https://i.imgur.com/5aueTiG.jpeg',
                    'https://i.imgur.com/rzy3URP.jpeg',
                    'https://i.imgur.com/ff6Tmhj.jpeg',
                ],
            ],

            [
                'car' => [
                    'brand' => 'Mercedes',
                    'model' => 'A 160',
                    'color' => 'Fekete',
                    'description' => 'A Mercedes-Benz A160 1.6 Turbo a Mercedes-Benz belépő szintű kompakt modellje. Az 1.6-os turbós benzinmotor kulturált és takarékos, miközben az autó prémium belsőt és kényelmes mindennapi használatot kínál.',
                    'year' => 2017,
                    'mileage' => 150000,
                    'fuel_type' => 'Benzin',
                    'transmission' => 'Manuális',
                    'engine_size' => 1600,
                    'body_type' => 'Ferdehátú',
                    'horsepower' => 105,
                ],
                'listing' => [
                    'price' => 3131313,
                    'status' => 'active',
                ],
                'photos' => [
                    'https://i.imgur.com/Oon1nME.jpeg',
                    'https://i.imgur.com/Rt7sc9U.jpeg',
                    'https://i.imgur.com/Ws4zVdT.jpeg',
                ],
            ],

            [
                'car' => [
                    'brand' => 'Audi',
                    'model' => 'A5',
                    'color' => 'Szürke',
                    'description' => 'Az Audi A5 2.0 TFSI az Audi elegáns, sportos kupéja. A 2.0 TFSI turbós benzinmotor jó teljesítményt és kulturált járást kínál, miközben az autó prémium belsővel és kényelmes utazással tűnik ki.',
                    'year' => 2009,
                    'mileage' => 200000,
                    'fuel_type' => 'Benzin',
                    'transmission' => 'Manuális',
                    'engine_size' => 2000,
                    'body_type' => 'Coupe',
                    'horsepower' => 200,
                ],
                'listing' => [
                    'price' => 13000000,
                    'status' => 'active',
                ],
                'photos' => [
                    'https://i.imgur.com/GR1CBwK.jpeg',
                ],
            ],

            [
                'car' => [
                    'brand' => 'BMW',
                    'model' => 'E36',
                    'color' => 'Szürke',
                    'description' => 'A BMW 318tds E36 a BMW 90-es évekbeli 3-as sorozatának takarékos dízel változata. Klasszikus hátsókerék-hajtása miatt így is megmarad a BMW-re jellemző stabil vezethetőség.',
                    'year' => 2000,
                    'mileage' => 200000,
                    'fuel_type' => 'Dízel',
                    'transmission' => 'Manuális',
                    'engine_size' => 1700,
                    'body_type' => 'Sedán',
                    'horsepower' => 90,
                ],
                'listing' => [
                    'price' => 2130000,
                    'status' => 'active',
                ],
                'photos' => [
                    'https://i.imgur.com/Pc8HfJW.jpeg',
                ],
            ],

            [
                'car' => [
                    'brand' => 'Volkswagen',
                    'model' => 'Golf 6',
                    'color' => 'Kék',
                    'description' => 'A Volkswagen Golf Mk6 1.2 TSI a Volkswagen egyik takarékos kompakt modellje. Az 1.2 TSI turbós benzinmotor kis fogyasztás mellett meglepően élénk, így ideális városi és mindennapi használatra.',
                    'year' => 2012,
                    'mileage' => 210000,
                    'fuel_type' => 'Benzin',
                    'transmission' => 'Manuális',
                    'engine_size' => 1200,
                    'body_type' => 'Ferdehátú',
                    'horsepower' => 105,
                ],
                'listing' => [
                    'price' => 2000000,
                    'status' => 'active',
                ],
                'photos' => [
                    'https://i.imgur.com/EVAWDb3.jpeg',
                    'https://i.imgur.com/RXJnhj3.jpeg',
                    'https://i.imgur.com/gOq2llL.jpeg',
                    'https://i.imgur.com/mOgbGE4.jpeg',
                ],
            ],

            [
                'car' => [
                    'brand' => 'Mitsubishi',
                    'model' => 'Lancer',
                    'color' => 'Piros',
                    'description' => 'A Mitsubishi Lancer 1.8 a Mitsubishi Motors megbízható kompakt modellje. Az 1.8-as benzinmotor egyszerű, tartós és mindennapi használatra ideális, miközben a Lancer stabil futóműve kellemes vezethetőséget biztosít.',
                    'year' => 2013,
                    'mileage' => 210000,
                    'fuel_type' => 'Benzin',
                    'transmission' => 'Automata',
                    'engine_size' => 1800,
                    'body_type' => 'Sedán',
                    'horsepower' => 145,
                ],
                'listing' => [
                    'price' => 3333333,
                    'status' => 'active',
                ],
                'photos' => [
                    'https://i.imgur.com/jI4uEhF.png',
                    'https://i.imgur.com/ElJKoiD.png',
                ],
            ],

            [
                'car' => [
                    'brand' => 'Volkswagen',
                    'model' => 'Golf 6',
                    'color' => 'Fekete',
                    'description' => 'A Volkswagen Golf Mk6 1.4 TSI 160 a Volkswagen erősebb kompakt változata. Az 1.4 TSI motor (kompresszor + turbó) 160 lóerőt ad, így kifejezetten dinamikus, miközben megmarad a Golf kényelme és mindennapi használhatósága.',
                    'year' => 2011,
                    'mileage' => 180000,
                    'fuel_type' => 'Benzin',
                    'transmission' => 'Manuális',
                    'engine_size' => 1400,
                    'body_type' => 'Ferdehátú',
                    'horsepower' => 160,
                ],
                'listing' => [
                    'price' => 3000000,
                    'status' => 'active',
                ],
                'photos' => [
                    'https://i.imgur.com/yWQnjh3.jpeg',
                    'https://i.imgur.com/oFz3bYu.png',
                    'https://i.imgur.com/3tJZCp6.jpeg',
                ],
            ],

            [
                'car' => [
                    'brand' => 'Volkswagen',
                    'model' => 'Golf 6 GTD',
                    'color' => 'Fehér',
                    'description' => 'A Volkswagen Golf Mk6 GTD a Volkswagen sportos dízel változata. A 2.0 TDI motor erős nyomatékot és alacsony fogyasztást kínál, így dinamikus, mégis gazdaságos mindennapi használatra.',
                    'year' => 2013,
                    'mileage' => 180000,
                    'fuel_type' => 'Dízel',
                    'transmission' => 'Manuális',
                    'engine_size' => 2000,
                    'body_type' => 'Ferdehátú',
                    'horsepower' => 170,
                ],
                'listing' => [
                    'price' => 3500000,
                    'status' => 'active',
                ],
                'photos' => [
                    'https://i.imgur.com/uBoa85e.jpeg',
                    'https://i.imgur.com/q0qacJf.jpeg',
                    'https://i.imgur.com/FOHBPxG.jpeg',
                ],
            ],
             [
                'car' => [
                    'brand' => 'Volkswagen',
                    'model' => 'Golf 6',
                    'color' => 'Fehér',
                    'description' => 'Megkímélt, jó állapotú Volkswagen Golf 6 eladó, rendszeresen karbantartott, megbízható és kényelmes autó, amely napi használatra és hosszabb utakra is tökéletes választás.',
                    'year' => 2012,
                    'mileage' => 128000,
                    'fuel_type' => 'Benzin',
                    'transmission' => 'Manuális',
                    'engine_size' => 1195,
                    'body_type' => 'Ferdehátú',
                    'horsepower' => 105,
                ],
                'listing' => [
                    'price' => 4200000,
                    'status' => 'active',
                ],
                'photos' => [
                    'https://i.imgur.com/4zqCFm7.jpeg',
                    'https://i.imgur.com/deBLUBo.jpeg',
                    'https://i.imgur.com/vugUtqh.jpeg',
                    'https://i.imgur.com/tgA7Wzy.jpeg',

                ],
            ],
            [
                'car' => [
                    'brand' => 'BMW',
                    'model' => 'E93',
                    'color' => 'Szürke',
                    'description' => 'Arany berakásos belső ezért drágább, jó állapotban van, rendszeresen karbantartott.',
                    'year' => 2012,
                    'mileage' => 128000,
                    'fuel_type' => 'Dízel',
                    'transmission' => 'Manuális',
                    'engine_size' => 3000,
                    'body_type' => 'Cabrio',
                    'horsepower' => 267,
                ],
                'listing' => [
                    'price' => 67000000,
                    'status' => 'active',
                ],
                'photos' => [
                    'https://i.imgur.com/kWcOkHi.jpeg',
                    'https://i.imgur.com/vVHi6oq.jpeg',
                    'https://i.imgur.com/UaRSuG9.jpeg',
                ],
            ],
        ];

        foreach ($examples as $index => $example) {
            $carData = $example['car'];
            $horsepower = (int) ($carData['horsepower'] ?? $example['listing']['horsepower'] ?? 0);

            unset($carData['horsepower']);

            $car = Car::create($carData);

            $listing = Listings::create([
                'user_id' => $user->id,
                'car_id' => $car->id,
                'price' => $example['listing']['price'],
                'horsepower' => $horsepower,
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