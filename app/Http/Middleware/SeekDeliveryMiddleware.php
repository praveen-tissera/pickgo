<?php

namespace App\Http\Middleware;

use App\Delivery;
use Closure;

class SeekDeliveryMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Delivery::hasDelivery()){
            abort(403);
        }
        return $next($request);
    }
}
