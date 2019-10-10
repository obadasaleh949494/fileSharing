<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\PassworddSecurity;
use DB;
class google2fa
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   if(Auth::user() ){
        $user=Auth::user();
        $sec = DB::table('passwordd_securities')->where('user_id', $user->id)->first();
        if($sec!=null ){
        if (  $sec->google2fa_enable) {
          return $next($request);
            }
        }
        }
            return redirect('/2fa');
    }
}
