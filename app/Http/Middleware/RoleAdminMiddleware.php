<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleAdminMiddleware
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
        if (Auth::user()->hasRole('Todo') || Auth::user()->hasRole('Admin')) {
                return $next($request);
            }else{
                return redirect('/order/venta_publico')->with('flash_message_error', 'No tienes permisos para ver la página seleccionada');    
            }
        }else{
            return route('login');
        }

        
    }
}
