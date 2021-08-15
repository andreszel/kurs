<?php

namespace App\Http\Controllers\Game;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class GameQBuilderController extends Controller
{
    // CRUD
    // C - create
    // R - 
    // U - update
    // D - delete

    public function index(): View
    {
        // wszystkie kolumny
        //$games = DB::table('games')->get();
        //tylko wybrane kolumny
        /* $games = DB::table('games')
            ->select('id', 'title', 'score', 'genre_id')
            ->get(); */
        $games = DB::table('games')
            ->join('genres', 'games.genre_id', '=', 'genres.id')
            ->join('publishers', 'games.publisher_id', '=', 'publishers.id')
            ->select(
                'games.id',
                'games.title',
                'games.score',
                'genres.name AS genre_name',
                'publishers.name AS publisher_name'
            )
            //->orderBy('title', 'asc')
            //->limit(5)
            //->offset(0)
            //->get();
            ->paginate(10);
        //->simplePaginate(10);

        // jeżeli dodajemy paginate(), simplePaginate(), get() to w odpowiedzi dostajemy JSONa

        return view('games.qbuilder.list', [
            'games' => $games
        ]);
    }

    public function dashboard(): View
    {
        $bestGames = DB::table('games')
            ->join('genres', 'games.genre_id', '=', 'genres.id')
            ->join('publishers', 'games.publisher_id', '=', 'publishers.id')
            ->select(
                'games.id',
                'games.title',
                'games.score',
                'genres.name AS genre_name',
                'publishers.name AS publisher_name'
            )
            ->where('score', '>', 9)
            //->where('score', 90) //uproszczona składnia to 2 args, domyślnie jest =
            ->orderBy('score', 'desc')
            //->orderByDesc('score')
            ->get();

        // UWAGA !!!
        // jeżeli nie dodamy ->get() to możemy podejrzeć zapytanie
        //dd($bestGames->toSql());

        // Więcej niż jeden warunek, pomiędzy warunkami AND
        /*
            $query = DB::table('games')
                ->select('id', 'title', 'score', 'genre_id')
                ->where([
                    ['score', '>', 90],
                    ['id', 55]
                ]);
        */
        // jeżeli więcej niż jeden warunek, ale z OR
        /*
        $query = DB::table('games')
            ->select('id', 'title', 'score', 'genre_id')
            ->where('score', '>', 95)
            ->orWhere('id', 55);
        */

        // sprawdzanie czy coś znajduje się w czymś
        /*
        $query = DB::table('games')
            ->select('id', 'title', 'score', 'genre_id')
            ->whereIn('id', [22,42,53]);
        */

        // sprawdzanie pomiędzy
        /* $query = DB::table('games')
            ->select('id', 'title', 'score', 'genre_id')
            ->whereBetween('id', [22,55]); */



        // FUNKCJE AGREGUJĄCE
        //$minScore = DB::table('games')->min('score');
        //$maxScore = DB::table('games')->max('score');
        //$avgScore = DB::table('games')->avg('score');

        $stats = [
            'count' => DB::table('games')->count(),
            'countScoreGtFive' => DB::table('games')->where('score', '>', 7)->count(),
            'min' => DB::table('games')->min('score'),
            'max' => DB::table('games')->max('score'),
            'avg' => DB::table('games')->avg('score')
        ];

        $scoreStats = DB::table('games')
            ->select('score', DB::raw('count(*) AS count'))
            ->having('count', '>', 10)
            ->groupBy('score')
            ->orderBy('count', 'desc')
            ->get();
        /* $scoreStats = DB::table('games')
            ->select('score', DB::raw('count(*) AS count'))
            ->having('count', '>', 10)
            ->groupBy('score')
            ->orderBy('score', 'desc')
            ->get(); */
        //dd($scoreStats);

        return view('games.qbuilder.dashboard', [
            'bestGames' => $bestGames,
            'stats' => $stats,
            'scoreStats' => $scoreStats
        ]);

        /* $faker = Factory::create();
        $games = [];

        for($i = 0; $i < 10; $i++){
            $game = [
                'name' => $faker->name,
                'number' => $faker->numberBetween(1,100),
                'copies' => $faker->numberBetween(1,100),
                'activate' => $faker->boolean
            ];
            array_push($games, $game);
        } */
    }

    public function show(int $gameId): View
    {
        // jeżeli odwołujemy się kilka razy do tej samej tabeli to robimy zmienną pomocniczą i odwołujemy się za pomocą niej, a nie za każdym razem powtarzamy
        //$gamesTable = DB::table('games');
        //$gamesTable->select();

        // jeżeli nie potrzebujemy tablicy z jednym elementem to pobieramy w innym sposób, np. first() lub findById
        //$game = DB::table('games')->where('id', $gameId)->get();
        //$game = DB::table('games')->where('id', $gameId)->first();
        $game = DB::table('games')->find($gameId);

        /**
         * UWAGA
         * Ostatnie dwa sposoby działają tak samo, ale find działa zawsze z kluczem głównym
         * Gdyby nie było id, zostanie zwrócony null, w widoku sprawdzamy funkcją empty, jeżeli będzie null to brak danych
         */

        return view('games.qbuilder.show', [
            'game' => $game
        ]);
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
            'title' => $faker->words($faker->numberBetween(1, 3), true),
            'description' => $faker->sentence,
            'publisher' => $faker->randomElement(['Atari', 'EA', 'Blizzard', 'Ubisoft', 'Sega', 'Sony', 'Nintendo']),
            'genre_id' => $faker->numberBetween(1, 5),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
        return response()->json($game);
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
