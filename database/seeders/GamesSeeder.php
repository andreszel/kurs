<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        DB::table('games')->truncate();

        /* for($i=0;$i<100;$i++){
            DB::table('games')->insert([
                'title' => $faker->words($faker->numberBetween(1,3), true),
                'description' => $faker->sentence,
                'publisher' => $faker->randomElement(['Atari','EA','Blizzard','Ubisoft','Epic Games']),
                'genre_id' => $faker->numberBetween(1,5),
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ]);
        } */

        // generowanie 1000 zapytań w pętli powoduje, że trwa to prawie 15 sekund
        // żeby to zrobić szybciej to robimy tablicę, która przekazujemy do zapytania i wykonujemy wtedy jedno zapytanie

        $games = [];
        for($j=0;$j<1;$j++){
            for($i=0;$i<100;$i++){
                $games[] = [
                    'title' => $faker->words($faker->numberBetween(1,3), true),
                    'description' => $faker->sentence,
                    //'publisher' => $faker->randomElement(['Atari','EA','Blizzard','Ubisoft','Sega','Sony','Nintendo']),
                    'publisher_id' => $faker->numberBetween(1,7),
                    'genre_id' => $faker->numberBetween(1,5),
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                    'score' => $faker->numberBetween(1,10)
                ];
            } 
            DB::table('games')->insert($games);
        }
    }
}
