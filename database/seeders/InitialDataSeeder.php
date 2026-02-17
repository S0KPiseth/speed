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
            DB::table('cities')->insert(['name' => $city]);
        }

        $carTypes = [
            'Sedan','Hatchback','SUV','MUV','Coupe','Convertible','Wagon',
            'Pickup Truck','Van','Minivan','Crossover','Sports Car','Supercar',
            'Hypercar','Roadster','Limousine','Off-Road','Electric','Hybrid'
        ];

        foreach ($carTypes as $type) {
            DB::table('car_types')->insert(['name' => $type]);
        }

        $fuelTypes = [
            'Petrol','Diesel','Electric','Hybrid','Plug-in Hybrid','CNG','LPG',
            'Hydrogen','Bio-diesel','Ethanol','Flex Fuel','Propane'
        ];

        foreach ($fuelTypes as $fuel) {
            DB::table('fuel_types')->insert(['name' => $fuel]);
        }
        DB::table("users")->insert(["firstName"=>"Piseth", "lastName"=>"Sok", "username"=>"ace", "email"=>"piseth.sok.dev@gmail.com", "password"=>bcrypt("1234")]);
    }
}
