<?php

namespace App\Http\Middleware;

use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;

class ThrottleRequests
{
    public function __invoke(Request $request, $next, $limit = '60,1')
    {
        // 60 запросов в минутупо умолчанию
        return $next($request);
    }
}
