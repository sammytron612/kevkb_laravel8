<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

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
      
        //$decrypt= Crypt::decryptString($request->token);
        
        if($request->token != "kevinlesliewilson13111969")
        {
            abort(401);
        } else
        {
        return $next($request);
        }
    }
}
