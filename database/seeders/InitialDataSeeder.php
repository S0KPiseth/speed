<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InitialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
        // Cities in Cambodia
        $cities = [
            'Phnom Penh','Siem Reap','Battambang','Sihanoukville','Kampot',
            'Kampong Cham','Kampong Chhnang','Kampong Speu','Kampong Thom','Kandal',
            'Kep','Koh Kong','Kratie','Mondulkiri','Oddar Meanchey',
            'Pailin','Preah Vihear','Prey Veng','Pursat','Ratanakiri',
            'Stung Treng','Svay Rieng','Takeo','Banteay Meanchey','Tboung Khmum'
        ];

        foreach ($cities as $city) {
            DB::table('cities')->updateOrInsert(['name' => $city], ['name' => $city]);
        }

        $carTypes = [
            'Sedan','Hatchback','SUV','MUV','Coupe','Convertible','Wagon',
            'Pickup Truck','Van','Minivan','Crossover','Sports Car','Supercar',
            'Hypercar','Roadster','Limousine','Off-Road','Electric','Hybrid'
        ];

        foreach ($carTypes as $type) {
            DB::table('car_types')->updateOrInsert(['name' => $type], ['name' => $type]);
        }

        $fuelTypes = [
            'Petrol','Diesel','Electric','Hybrid','Plug-in Hybrid','CNG','LPG',
            'Hydrogen','Bio-diesel','Ethanol','Flex Fuel','Propane'
        ];

        foreach ($fuelTypes as $fuel) {
            DB::table('fuel_types')->updateOrInsert(['name' => $fuel], ['name' => $fuel]);
        }

        DB::table('users')->updateOrInsert(
            ['email' => 'piseth.sok.dev@gmail.com'],
            [
                'firstName' => 'Piseth',
                'lastName' => 'Sok',
                'username' => 'ace',
                'password' => bcrypt('1234'),
                'role' => 'admin',
                'phone' => '+85512345678',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $user = DB::table('users')->where('email', 'piseth.sok.dev@gmail.com')->first();

        $makerId = DB::table('makers')->where('name', 'Tesla')->value('id');
        if (! $makerId) {
            $makerId = DB::table('makers')->insertGetId(['name' => 'Tesla']);
        }

        $modelId = DB::table('models')->where('name', 'Model S')->where('maker_id', $makerId)->value('id');
        if (! $modelId) {
            $modelId = DB::table('models')->insertGetId([
                'maker_id' => $makerId,
                'name' => 'Model S',
            ]);
        }

        DB::table('cars')->updateOrInsert(
            ['vin' => '5YJSA1E26MF123456'],
            [
                'maker_id' => $makerId,
                'model_id' => $modelId,
                'year' => 2022,
                'price' => 79999,
                'mileage' => 15000,
                'car_type_id' => 1,
                'fuel_type_id' => 2,
                'city_id' => 1,
                'user_id' => $user?->id,
                'phone' => '+85512345678',
                'address' => '123 Street, Phnom Penh',
                'description' => 'Well maintained Tesla Model S, full self-driving capability, no accidents, excellent condition.',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        $car = DB::table('cars')->where('vin', '5YJSA1E26MF123456')->first();

        if ($car) {
            DB::table('car_features')->updateOrInsert(
                ['car_id' => $car->id],
                [
                    'air_conditioning' => 1,
                    'bluetooth_connectivity' => 1,
                    'rear_parking_sensors' => 1,
                    'gps_navigation' => 1,
                    'heater_seats' => 1,
                ]
            );

            DB::table('car_images')->where('car_id', $car->id)->delete();
            DB::table('car_images')->insert([
                [
                    'car_id' => $car->id,
                    'image_path' => 'https://ik.imagekit.io/aceontop/1771558261models_6rmHh_9ECX.png?updatedAt=1771558265084',
                    'position' => 0,
                    'image_id' => '6997d5785c7cd75eb8e22919',
                ],
                [
                    'car_id' => $car->id,
                    'image_path' => 'https://ik.imagekit.io/aceontop/1771558265modelsInterior_5hwKtVtoR.png?updatedAt=1771558269423',
                    'position' => 1,
                    'image_id' => '6997d57d5c7cd75eb8e2364b',
                ],
                [
                    'car_id' => $car->id,
                    'image_path' => 'https://ik.imagekit.io/aceontop/1771558270download__1__o6rXLb5Ngt.png?updatedAt=1771558274176',
                    'position' => 2,
                    'image_id' => '6997d5815c7cd75eb8e24ba3',
                ],
                [
                    'car_id' => $car->id,
                    'image_path' => 'https://ik.imagekit.io/aceontop/1771558274modelsFrontView_UVcWlN3tg.png?updatedAt=1771558277824',
                    'position' => 3,
                    'image_id' => '6997d5855c7cd75eb8e25fe7',
                ],
                [
                    'car_id' => $car->id,
                    'image_path' => 'https://ik.imagekit.io/aceontop/1771558278modelsBack_e7B51yfd7y.png?updatedAt=1771558279155',
                    'position' => 4,
                    'image_id' => '6997d5865c7cd75eb8e26a3a',
                ],
            ]);
        }

        if ($user) {
            DB::table('account_verification')->updateOrInsert(
                ['user_id' => $user->id],
                [
                    'email_verified' => false,
                    'phone_verified' => false,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
