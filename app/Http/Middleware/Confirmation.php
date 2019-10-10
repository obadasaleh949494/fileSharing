<?php

namespace App\Http\Middleware;

use Closure;
use auth;

class Confirmation
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
        if (Auth::user() &&  Auth::user()->confirmed == 1) {
            return $next($request);
              }
              $confirm="Can not access this link. you have to confirm your account.";
              return redirect('/user/account')->with('str',$confirm);
    }
}
