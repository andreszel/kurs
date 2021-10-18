<?php

namespace App\Http\Controllers\Game;

use App\Facade\Game;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Repository\GameRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

//use App\Repository\Builder\GameRepository;
//use App\Repository\Eloquent\GameRepository;
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

    public function index(Request $request): View
    {
        $phrase = $request->get('phrase');
        $type = $request->get('type',  GameRepository::TYPE_DEFAULT);
        $limit = $request->get('limit', GameRepository::LIMIT_DEFAULT);

        $resultPaginator = $this->gameRepository->filterBy($phrase, $type, $limit);
        $resultPaginator->appends([
            'phrase' => $phrase,
            'type' => $type
        ]);

        return view('games.game.list', [
            'games' => $resultPaginator,
            'phrase' => $phrase,
            'type' => $type
            //'games' => $this->gameRepository->allPaginated(10)
            //'games' => Game::allPaginated(10)
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
        $user = Auth::user();
        $userHasGame = $user->hasGame($gameId);
        
        return view('games.game.show', [
            'game' => $this->gameRepository->get($gameId),
            'userHasGame' => $userHasGame
        ]);
    }
}
