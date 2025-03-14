<?php

namespace Database\Seeders;

use App\Models\Airline;
use App\Models\City;
use App\Models\Flight;
use Faker\Factory;
use Illuminate\Database\Seeder;

class FlightSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();

        $airlines = Airline::query()
            ->with('planes');

        foreach ($airlines->cursor() as $airline) {
            $departure  = $faker->dateTimeBetween('now', '+2 days');
            $arrival    = $faker->dateTimeBetween($departure, '+2 days');

            $departure_time = $faker->dateTimeBetween($departure, $departure->format('Y-m-d') . ' 23:59:59')->format('H:i:s');  
            $arrival_time = $faker->dateTimeBetween($arrival, $arrival->format('Y-m-d') . ' 23:59:59')->format('H:i:s'); 
            foreach ($airline->planes as $plane) {
                Flight::query()->create([
                    "flight_number" => $faker->unique()->numberBetween(100, 999),
                    'airline_id' => $airline->id,
                    'plane_id' => $plane->id,
                    "origin_id" => City::query()->inRandomOrder()->first()->id,
                    "destination_id" => City::query()->inRandomOrder()->first()->id,
                    "departure" => $departure,
                    "arrival" => $arrival,
                    "seats" => $plane->capacity,
                    "remain_seats" => rand(1, $plane->capacity),
                    "price" => rand(100, 1000),
                    'status' => $faker->boolean(),
                    "departure_time" => $departure_time,
                    "arrival_time" => $arrival_time,
                ]);
            }
        }
    }
}
