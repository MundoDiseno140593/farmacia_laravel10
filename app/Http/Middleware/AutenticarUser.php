<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class AutenticarUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, int $necesitologin=0): Response
    {
        if($necesitologin){
            if(Auth::check()){
                return $next($request);
            }
            
            return Redirect::route('login')->withErrors(['error'=>'Session Expirada. Por favor, Inicie session de Nuevo']);
        }

        if (!Auth::check()) {
            return $next($request);
        }

        return Redirect::route('home');
    }
}
