<?php

declare(strict_types=1);

namespace App\Facade;

use App\Repository\Builder\GameRepository;
use Illuminate\Support\Facades\Facade;

class Game extends Facade
{
    /**
     * Klasa fasady musi mieć jedną metodę statyczną getFacadeAccessor
     * metoda zwraca stringa, a tym stringiem jest klucz w kontenerze obiektu, który tam się znajduje
     * jeżeli nie będzie tej metody framework rzuci wyjątek
     * fasada w naszym przypadku działa dzięki metodzie magicznej __callStatic, którą PHP uruchamia, jeżeli
     * wywoływana metoda nie istnieje, allPaginated(10)
     */
    protected static function getFacadeAccessor()
    {
        /**
         * Tutaj zwracamy już konkretną klasę - obiekt, 
         * co gdybyśmy chcieli to jakoś modyfikować
         */
        return GameRepository::class;

        /**
         * Może zrobić tak, że umieścimy nowy klucz w kontenerze
         * jako uzupełnienie kontenera w GameServiceProvider
         */
        //return 'game';
        // z service providera
        //$this->app->singleton('game', GameRepository::class);
    }
}