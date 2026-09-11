<?php

namespace App\Http\Middleware;

use Closure;

class CampusOneOnly
{
    public function handle($request, Closure $next)
    {
        abort_unless((int) session('campus') === 1, 403, 'This feature is available only to Campus 1.');

        return $next($request);
    }
}
