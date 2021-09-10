<?php
//Jeżeli tworzymy repozytorium, to najlepiej jest najpierw zastanowić się jakie będzie interfejs, jakie będą potrzebne metody 
declare(strict_types=1);

namespace App\Repository;

use App\Models\Game;

class GameRepository
{
    public Game $gameModel;

    public function __construct(Game $gameModel)
    {
        $this->gameModel = $gameModel;
    }

    public function get(int $id)
    {
        // można w ten sposób, ale wtedy use Model Game
        //return Game::find($id);
        // Można w ten sposób i tak jest zalecane, żeby wstrzykiwać klasę do konstruktora
        return $this->gameModel->find($id);
    }

    public function all()
    {
        return $this->gameModel
            ->with(['genre', 'publisher'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function allPaginated(int $limit)
    {
        return $this->gameModel->with(['genre', 'publisher'])
            ->orderBy('created_at', 'desc')
            ->paginate($limit);
    }

    // różne podejścia do nazewnictwa metod
    //public function getBestGame()
    public function best()
    {
        return $this->gameModel
            ->best()
            ->get();
    }

    public function stats()
    {
        return [
            'count' => $this->gameModel->count(),
            'countScoreGtFive' => $this->gameModel->where('score', '>', 7)->count(),
            'min' => $this->gameModel->min('score'),
            'max' => $this->gameModel->max('score'),
            'avg' => $this->gameModel->avg('score')
        ];
    }

    public function scoreStats()
    {
        return $this->gameModel->select(
            $this->gameModel->raw('count(*) AS count'),
            'score'
        )
            ->having('count', '>', 10)
            ->groupBy('score')
            ->orderBy('count', 'desc')
            ->get();
    }
}
