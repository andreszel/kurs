<?php

declare(strict_types=1);

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainPage extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return view('home.main');
        
        //$db = \DB::connection('gameworld');
        //dd($db);
        //$config = config('app.name');

        //jak umieszczać rekordy w bazie danych
        //czyści tablicę i resetuje klucz główny
        DB::table('genres')->truncate();
        //czyści tabelę, ale nie resetuje klucza głównego
        //DB::table('genres')->delete();
        DB::table('genres')->insert(
            [
                'name' => 'RPG',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
        DB::table('genres')->insert([
            [
                'name' => 'Adventure',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'FPS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
        //jeżeli name istnieje taki już w tabeli to może obejść to w taki sposób
        DB::table('genres')->insertOrIgnore([
            [
                'name' => 'Adventure',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'FPS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
        // ważne, w każdym wpisie muszą być takie same klucze,
        //nie może być, np. w pierwszym id a w drugim i trzecim nie
        DB::table('genres')->insertOrIgnore([
            [
                'id' => 1,
                'name' => 'Adventure',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 23,
                'name' => 'FPS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 15,
                'name' => 'Fortnite',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
        //autoincrement działa zawsze od największego id
        DB::table('genres')->insert(
            [
                'name' => 'TPP',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        //jeżeli potrzebujemy dostać id
        $id = DB::table('genres')->insertGetId(
            [
                'name' => 'SIMS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
        //dump($id);

        // jak zrobić update wpisu
        DB::table('genres')
            ->where('id', 15)
            ->update(['name'=>'Strategy']);
        
        //jak usunąć rekord
        DB::table('genres')
            ->where('id', 15)
            ->delete();
    }
}
