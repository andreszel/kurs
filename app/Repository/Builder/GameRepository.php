<?php
//Jeżeli tworzymy repozytorium, to najlepiej jest najpierw zastanowić się jakie będzie interfejs, jakie będą potrzebne metody 
declare(strict_types=1);

namespace App\Repository\Builder;

use App\Models\Game;
use App\Repository\GameRepository as GameRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use stdClass;

class GameRepository implements GameRepositoryInterface
{
    public Game $gameModel;

    public function __construct(Game $gameModel)
    {
        $this->gameModel = $gameModel;
    }

    public function get(int $id)
    {
        $data = DB::table('games')
            ->join('genres', 'games.genre_id', '=', 'genres.id')
            ->join('publishers', 'games.publisher_id', '=', 'publishers.id')
            ->select(
                'games.id',
                'games.title',
                'games.score',
                'games.description',
                'genres.name AS genre_name',
                'publishers.name AS publisher_name'
            )
            ->where('games.id', $id)
            ->limit(1)
            ->first();
        //find($id) nie możemy zastosować, ponieważ działa domyślnie na kolumnie id, a w where możemy sobie wybrać

        //dd($data);

        return $this->createGame($data);
    }

    public function all()
    {
        return DB::table('games')
            ->join('genres', 'games.genre_id', '=', 'genres.id')
            ->join('publishers', 'games.publisher_id', '=', 'publishers.id')
            ->select(
                'games.id',
                'games.title',
                'games.score',
                'genres.name AS genre_name',
                'publishers.name AS publisher_name'
            )
            ->get()
            ->map(fn ($row) => $this->createGame($row));
    }

    public function allPaginated(int $limit)
    {
        //metoda resolveCurrentPage może pobrać wartość stronę na której aktualnie jesteśmy po nazwie parametru, który w naszym przypadku jest page
        $pageName = 'page';
        $currentPage = Paginator::resolveCurrentPage($pageName);

        //ilość rekordów
        $baseQuery = DB::table('games')
            ->join('genres', 'games.genre_id', '=', 'genres.id')
            ->join('publishers', 'games.publisher_id', '=', 'publishers.id');

        $total = $baseQuery->count();

        $data = collect();
        //$total = 0;

        if ($total) {
            $data = $baseQuery
                ->select(
                    'games.id',
                    'games.title',
                    'games.score',
                    'genres.name AS genre_name',
                    'publishers.name AS publisher_name'
                )
                ->latest('games.created_at')
                ->forPage($currentPage, $limit)
                ->get()//zwracana jest kolekcja, a metoda map() działa na kolekcji
                ->map(fn ($row) => $this->createGame($row));
        }

        /**
         * $items,
         * $total,
         *  $perPage,
         *  $currentPage = null,
         *  array $options = []
         */
        return new LengthAwarePaginator(
            $data,
            $total,
            $limit,
            $currentPage,
            [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => $pageName,

            ]
        );
    }

    // różne podejścia do nazewnictwa metod
    //public function getBestGame()
    public function best()
    {
        $data = DB::table('games')
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
            ->orderBy('score', 'desc')
            ->get()//zwracana jest kolekcja, a metoda map() działa na kolekcji
            ->map(fn ($row) => $this->createGame($row)); // jeżeli zwrócilibyśmy data, to jest problem z items, stosujemy mapowanie danych, używamy map() z argumentem

        return $data;
    }

    public function stats()
    {
        return [
            'count' => DB::table('games')->count(),
            'countScoreGtFive' => DB::table('games')->where('score', '>', 7)->count(),
            'min' => DB::table('games')->min('score'),
            'max' => DB::table('games')->max('score'),
            'avg' => DB::table('games')->avg('score')
        ];
    }

    public function scoreStats()
    {
        return DB::table('games')
            ->select('score', DB::raw('count(*) AS count'))
            ->having('count', '>', 10)
            ->groupBy('score')
            ->orderBy('count', 'desc')
            ->get();
    }

    private function createGame(stdClass $game): stdClass
    {
        // tworzymy obiekty standardowej klasy, które zwracają
        $genre = new stdClass();
        $genre->name = $game->genre_name;

        $publisher = new stdClass();
        $publisher->name = $game->publisher_name;


        $game->genre = $genre;
        $game->publisher = $publisher;

        unset($game->genre_name, $game->publisher_name);

        return $game;
    }
}
