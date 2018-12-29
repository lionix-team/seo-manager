<?php

namespace Lionix\SeoManager\Middleware;

use Closure;
use Illuminate\Support\Facades\Artisan;

class ClearViewCache
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
        Artisan::call('view:clear');
        return $next($request);
    }
}
