<?php

declare(strict_types=1);

namespace App\Repository;

//GameRepositoryInterface - dajemy bez Interface bo na początku jest interface i wiemy co to jest
interface GameRepository
{
    public function get(int $id);
    public function all();
    public function allPaginated(int $limit);
    //public function getBestGame();
    public function best();
    public function stats();
    public function scoreStats();
}
