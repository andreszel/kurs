<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MoviesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        DB::table('movies')->truncate();

        $movies = [];
        for($j=0;$j<10;$j++){
            for($i=0;$i<100;$i++){
                $movies[] = [
                    'title' => $faker->words($faker->numberBetween(1,3), true),
                    'description' => $faker->sentence,
                    'url' => $faker->url(),
                    'game_id' => $faker->numberBetween(1,100),
                    'duration_time' => $faker->numberBetween(55,450),
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now()
                ];
            } 
            DB::table('movies')->insert($movies);
        }
    }
}
