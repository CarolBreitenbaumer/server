<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use JWTAuth;

class Admin
{
    /**
     * Handle an incoming request
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        //hole den derzeit angemeldeten User
        $user = JWTAuth::parseToken()->authenticate();
        //bei null und not Admin nicht die notwendigen Rechte
        if(Auth::user() && Auth::user()->isAdmin){
            return $next($request);
        }
        return response()->json(['User ist kein Administrator.'], 401);
    }
}
