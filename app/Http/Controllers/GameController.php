<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faker = Factory::create();
        $games = [];

        for($i = 0; $i < 10; $i++){
            $game = [
                'name' => $faker->name,
                'number' => $faker->numberBetween(1,100),
                'copies' => $faker->numberBetween(1,100),
                'activate' => $faker->boolean
            ];
            array_push($games, $game);
        }
        
        return view('games.list', ['games' => $games]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestName = $request->input('name');
        $test = $request->input('test');
        
        $faker = Factory::create();

/*         $game = [
                'name' => $faker->name,
                'number' => $faker->numberBetween(1,100),
                'copies' => $faker->numberBetween(1,100),
                'activate' => $faker->boolean,
                'message' => 'Game added. Thank you.',
                'author' => $requestName
            ]; */
        $game = [
                    'title' => $faker->words($faker->numberBetween(1,3), true),
                    'description' => $faker->sentence,
                    'publisher' => $faker->randomElement(['Atari','EA','Blizzard','Ubisoft','Sega','Sony','Nintendo']),
                    'genre_id' => $faker->numberBetween(1,5),
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now()
                ];
        return response()->json($game);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
