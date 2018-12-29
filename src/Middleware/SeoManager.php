<?php

namespace Lionix\SeoManager\Middleware;

use Closure;

class SeoManager
{
    /**
     * Handle an incoming request.
     *]
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        \View::share('metaData', metaData());

        return $next($request);
    }
}
