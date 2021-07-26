<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PublishersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('publishers')->truncate();

        DB::table('publishers')->insert([
            ['id' => 1,'name' => 'Atari', 'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()],
            ['id' => 2,'name' => 'EA', 'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()],
            ['id' => 3,'name' => 'Blizzard', 'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()],
            ['id' => 4,'name' => 'Ubisoft', 'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()],
            ['id' => 5,'name' => 'Sega', 'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()],
            ['id' => 6,'name' => 'Sony', 'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()],
            ['id' => 7,'name' => 'Nintendo', 'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]
        ]);
    }
}
