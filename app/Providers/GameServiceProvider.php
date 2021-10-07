<?php

namespace App\Providers;

use App\Repository\Builder\GameRepository as BuilderGameRepository;
use App\Repository\GameRepository;
use Illuminate\Support\ServiceProvider;
use App\Repository\Eloquent\GameRepository as EloquentGameRepository;

class GameServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            GameRepository::class,
            EloquentGameRepository::class
        );

        $this->app->singleton('game', GameRepository::class);

        /* $this->app->when(GameQBuilderController::class)
            ->needs(BuilderGameRepository::class)
            ->give(GameRepository::class) */
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
