<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Pagination
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
        if ($request->has('page')) {
            $page = (int)$request->query('page');

            if ($page <= 0) {
                $page = 1;

                $newUrl = url()->current() . "?";
                foreach ($request->query() as $key => $value) {
                    if ($key == 'page')
                        $newUrl .= $key . '=' . $page;
                    else
                        $newUrl .= $key . '=' . $value;
                }

                return redirect($newUrl);
            }
        }

        return $next($request);
    }
}
