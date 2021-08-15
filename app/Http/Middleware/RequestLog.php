<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class RequestLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // kod przed
        $currentDate = Carbon::now();
        $timeStart = microtime(true); //opcja true to float

        Log::info('==========================');
        Log::info($currentDate . ': BEFORE: ' . $timeStart);

        // przekazanie do następnego middleware lub do kontrolera, jeżeli nie ma następnych middleware-ów 
        $response = $next($request);

        // kod po
        $timeEnd = microtime(true); //opcja true to float

        Log::info($currentDate . ': AFTER: ' . $timeEnd);

        Log::info($currentDate . ': Time execution: ' . ($timeEnd - $timeStart));


        return $response;
    }
}

/**
 * Ważne!
 * Implementacja middleware to zastosowanie wzorca Chain of Responsibility (łańcuch zobowiązań)
 * Middleware możemy dołączyć globalnie(dla wszystkich requestów), możemy też dodać go w inny sposób
 * Przykładowo możemy dodać go do dowolnej grupy zdefiniowanej lub własnej, którą można dodać w Kernel.php
 * Jeżeli tak zrobimy to musimy dodać ten middleware w routingu dla group, gdzie dodajemy klucz 'middleware' => ['profiling']
 * Innym sposobem może być jawne użycie na klasie Route
 * ...Route::middleware((['profiling']))->group(function () {});...
 * Obydwa przypadki zapisane są w web.php
 * Możemy również zamiast nazwy grupy podać nazwę konkretnego middleware
 * ...Route::middleware([RequestLog::class])->group...
 * Używając klasy a nie całej ścieżki trzeba dodać use
 * use App\Http\Middleware\RequestLog;
 * Możemy również użyć dla konkretnej trasy route, dodajemy tylko kolejny chain ->middleware(['profiling']); lub ->middleware([RequestLog::class]);
 */
