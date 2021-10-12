<?php

declare(strict_types=1);

namespace App\Repository;

//GameRepositoryInterface - dajemy bez Interface bo na początku jest interface i wiemy co to jest
interface GameRepository
{
    public const TYPE_DEFAULT = 'game';
    public const TYPE_ALL = 'all';
    public const LIMIT_DEFAULT = 15;
    public const ALLOW_TYPES = array(
        'all',
        'game',
        'dlc',
        'demo',
        'episode',
        'mod',
        'movie',
        'music',
        'series',
        'video'
    );

    public function get(int $id);
    public function all();
    public function allPaginated(int $limit);
    //public function getBestGame();
    public function best();
    public function stats();
    public function scoreStats();

    public function filterBy(?string $phrase, string $type = self::TYPE_DEFAULT, int $limit = self::LIMIT_DEFAULT);
}
