<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // zmienne współdzielone, które przydatne są dla w wielu widokach
        // używamy ich bezpośrednio w widoku
        view()->share('appName', 'Świat GIER');
        View::share('titleName', 'Games App');
    }
}
