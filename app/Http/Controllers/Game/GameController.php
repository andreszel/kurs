<?php

namespace App\Http\Controllers\Game;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use App\Repository\Builder\GameRepository;
//use App\Repository\Eloquent\GameRepository;
use App\Repository\GameRepository;
// Tutaj nie o to chodzi, żeby podmieniać repository, tylko żeby wstrzykiwać interface
// w naszym przypadku musimy zapoznać się z service providerami, żeby naprawić błąd
// Illuminate\Contracts\Container\BindingResolutionException

/**
 * obie implementacja builder, eloquent muszą zwracać te same dane, tą samą strukturę
 */

class GameController extends Controller
{
    private GameRepository $gameRepository;

    public function __construct(GameRepository $repository)
    {
        $this->gameRepository = $repository;
    }

    public function index(): View
    {
        return view('games.game.list', [
            'games' => $this->gameRepository->allPaginated(10)
        ]);
    }

    public function dashboard(): View
    {
        return view('games.game.dashboard', [
            'bestGames' => $this->gameRepository->best(),
            'stats' => $this->gameRepository->stats(),
            'scoreStats' => $this->gameRepository->scoreStats()
        ]);
    }

    public function show(int $gameId, Request $request): View
    {
        return view('games.game.show', [
            'game' => $this->gameRepository->get($gameId)
        ]);
    }
}
