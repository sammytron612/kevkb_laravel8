<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;


class kbFront
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
        
        if($request->token != "kevinlesliewilson13111969")
        {
            abort(401);
        } else
        {
        return $next($request);
        }
    }
}
