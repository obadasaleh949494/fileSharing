<?php
namespace App\Http\MiddleWare;
use closure;
use App\Support\Google2FAAuthentication;
class Google2FAMiddleware
{
	
    public function handle($request, Closure $next)
    {
    	$authentication =app(Google2FAAuthentication::class)->boot($request	);
        if ($authentication->isAuthenticated()) {
            return redirect($request);
        }

        return $authentication->makeRequestOneTimePasswordResponse();
    }
}