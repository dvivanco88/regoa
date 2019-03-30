<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleDeveloperAdminMiddleware
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
        if (Auth::check()){
        if (Auth::user()->hasRole('Todo')) {
                return $next($request);
            }else{
                return redirect('/admin')->with('flash_message_error', 'No tienes permisos para ver la página seleccionada');    
            }
        }else{
            return route('login');
        }
    }
}
