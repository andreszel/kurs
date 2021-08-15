<?php

namespace App\Http\Controllers\Game;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Publisher;

class GameEloquentController extends Controller
{
    // CRUD
    // C - create
    // R - 
    // U - update
    // D - delete

    public function index(): View
    {
        // INSERT DATA
        /* $newPublisher = new Publisher();
        $newPublisher->name = 'Edios';
        $newPublisher->save(); */

        /* $newGame = new Game();
        $newGame->title = 'Tomb Raider';
        $newGame->description = 'Przygoda, skarby itp.';
        $newGame->score = 9;
        $newGame->publisher_id = 8;
        $newGame->genre_id = 4;

        $newGame->save(); */

        // W przykładzie powyżej świadomienie przekazujemy parametry
        // W tym przypadku może być tak, że przekażemy obiekt request i gdyby to była tabela users
        // to moglibyśmy mieć poważną lukę w bezpieczeństwie, bo ktoś mógłby przekazać flagę
        // is_admin o wartości true
        /* Game::create([
            'title' => 'Tomb Raider 2',
            'description' => "Gra ...",
            'score' => 8,
            'publisher_id' => 8,
            'genre_id' => 4
        ]); */

        /* $newGame = new Game([
            'title' => 'Tomb Raider 2',
            'description' => "Gra ...",
            'score' => 8,
            'publisher_id' => 8,
            'genre_id' => 4
        ]);
        $newGame->save(); */

        // UPDATE DATA
        // Aktualizacja jednego rekordu
        /* $game = Game::find(123);
        $game->description = 'Opis po aktualizacji';
        $game->genre_id = 3;
        $game->save(); */

        // Gdybyśmy chcieli zaktualizować wszystkie obiekty musielibyśmy zrobić foreach, a w nim podobnie jak powyżej
        // foreach($gameIds as $gameId), zdarzają się sytuacje, że potrzebne będzie zastosowanie pętli foreach
        // bo na podstawie pobranego obiektu rekordu wykonujemy dodatkowe zapytanie, które coś pobiera i dopiero tą wartość aktualizuejmy
        //$gameIds = [120, 121, 122, 123];

        // Aktualizacja więcej niż jednego rekordu
        /* Game::where('id', $gameIds)
            ->update([
                'description' => 'Bez pobierania'
            ]); */


        // DELETE DATA

        // Sposób 1 - najpierw wyciągamy(select), później usuwamy(delete)
        /* $game = Game::find(123);
        $forDelete = false;
        // ... dodatkowa logika, np. czy należy usunąć
        $forDelete = true;
        if ($forDelete) {
            $game->delete();
        } */

        // Sposób 2 - klasyczny delete, zapytanie to nie zwróci błędu, bo jest poprawne i zawsze sięwykona, ale nie usunie się rekord
        //Game::destroy(122);
        // Usunięcie więcej niż jednego rekordu
        //Game::destroy(121,122);
        // Usunięcie więcej niż jednego rekordu, argument array
        //Game::destroy([121,122]);
        // Sposób 3 - z powodu optymalizacji najlepsze
        //Game::whereIn('id', [118, 119])->delete();


        // jedna relacja
        //$games = Game::with('genre')->orderBy('created_at', 'asc')->paginate(10);
        $games = Game::with(['genre', 'publisher'])
            //->publisher(8)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        // relacja ma relacje
        //$games = Game::with(['genre', 'movie.author'])->orderBy('created_at', 'asc')->paginate(10);

        return view('games.eloquent.list', [
            'games' => $games
        ]);
    }

    public function dashboard(): View
    {
        // with możemy przenieść do scope
        $bestGames = Game::best()
            // normalne wywołanie warunku
            //->where('score', '>', 9)
            // użycie mechanizmu scope, który definiujemy w modelu
            // dzięki temu nie musimy w wielu miejscach pisać tego samego, zmiana jest tylko w jednym miejscu
            //->best()
            ->get();

        $stats = [
            'count' => Game::count(),
            'countScoreGtFive' => Game::where('score', '>', 7)->count(),
            'min' => Game::min('score'),
            'max' => Game::max('score'),
            'avg' => Game::avg('score')
        ];

        $scoreStats = Game::select(
            Game::raw('count(*) AS count'),
            'score'
        )
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

        return view('games.eloquent.dashboard', [
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

    public function show(int $gameId, Request $request): View
    {
        // Jak realizowane jest żądanie użytkownika bez middleware'a i z middleware'em
        // request z middlewarem jest wykonywany z każdym kontrolerem
        // możemy np. dla wszystkich kontrolerów filtrować jakieś dane
        // przykładem może być pomiar szybkości wykonywania requestów na naszej stronie
        // możemy to zrobić za pomocą middleware, to logujemy czas początkowy, czas końcowy, obliczymy różnicę i mamy czas
        // middleware może owijać się wokół wszystkich kontrolerów, robimy to w jednej klasie
        // innym zastosowaniem jest autoryzacja, ponieważ już przed jakimkolwiek wczytaniem danych możemy sprawdzić kto to jest, czy ma prawo do odczytu takiego requestu

        //============================ MIDDLEWARE

        // REQUEST trafia do KONTROLERA, wykonywane są różne potrzebne operacje(LOGIKA) i dalej to trafia do logiki biznesowej(domenowej)
        $isAjax = false;
        if ($request->ajax()) {
            $isAjax = true;
        }

        //============================ LOGIKA BIZNESOWA

        $game = Game::find($gameId);
        // jeżeli brak id to 404
        //$game = Game::findOrFail($gameId);
        // dwa tożsame sposoby, drugi trochę krótszy zapis
        //$game = Game::where('id', $gameId)->first();
        //$game = Game::firstWhere('id', $gameId);

        //============================ ODPOWIEDŹ DO KONTROLERA

        // GENEROWANIE RESPONSE
        if ($isAjax) {
            return $game;
        } else {
            return view('games.eloquent.show', [
                'game' => $game
            ]);
        }

        //============================ MIDDLEWARE
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
