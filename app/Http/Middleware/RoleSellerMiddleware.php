<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class RoleSellerMiddleware
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
            if (!Auth::user()->hasRole('Todo') && !Auth::user()->hasRole('Admin') && (Route::current()->uri == "product/products/create" 
                || Route::current()->uri == "product/products/{product}/edit"
                || (Route::current()->uri == "product/products/{product}" && Route::current()->methods == "DELETE")
                || Route::current()->uri == "warehouse/warehouses/create" 
                || Route::current()->uri == "warehouse/warehouses/{warehouse}/edit"
                || (Route::current()->uri == "warehouse/warehouses/{warehouse}" && Route::current()->methods == "DELETE")
                || Route::current()->uri == "inventory/inventories/create" 
                || Route::current()->uri == "inventory/inventories/{inventory}/edit"
                || (Route::current()->uri == "inventory/inventories/{inventory}" && Route::current()->methods == "DELETE")  )) {                                
                return redirect('/order/venta_publico')->with('flash_message_error', 'No tienes permisos para ver la página seleccionada');   
        }
        return $next($request);
    }else{
        return route('login');
    }

}
}
