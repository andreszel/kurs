<?php
//Jeżeli tworzymy repozytorium, to najlepiej jest najpierw zastanowić się jakie będzie interfejs, jakie będą potrzebne metody 
declare(strict_types=1);

namespace App\Repository\Eloquent;

use App\Models\Game;
use App\Repository\GameRepository as GameRepositoryInterface;

class GameRepository implements GameRepositoryInterface
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
            ->with(['genres', 'publishers'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function allPaginated(int $limit)
    {
        return $this->gameModel
            ->with(['genres', 'publishers'])
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
            'countScoreGtSeventy' => $this->gameModel->where('metacritic_score', '>', 70)->count(),
            'max' => $this->gameModel->max('metacritic_score'),
            'min' => $this->gameModel->min('metacritic_score'),
            'avg' => round((int)$this->gameModel->avg('metacritic_score'), 2)
        ];
    }

    public function scoreStats()
    {
        return $this->gameModel->select(
            $this->gameModel->raw('count(*) AS count'), 'metacritic_score'
            )
            ->having('metacritic_score', '>=', 70)
            ->groupBy('metacritic_score')
            ->orderBy('metacritic_score', 'desc')
            ->get();
    }
}
