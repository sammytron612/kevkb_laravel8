<?php

namespace App\Http\Middleware;

use Closure;
use Session;


class OTP
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
        if (Session::get('otp'))

        {return $next($request);}
        else {
            return redirect('otp');
        }
    }
}
