<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Order;
use App\Warehouse;
use App\Inventory;
use App\Product;
use App\PublicSale;
use App\OrderClient;
use App\Client;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
    	$orders = OrderClient::selectRaw("
    		DISTINCT(clients.name) as name, CONVERT(SUM(DISTINCT(CONVERT(orders.due, UNSIGNED INTEGER))), UNSIGNED INTEGER) as y")
    	->join('orders', 'order_clients.order_id', '=', 'orders.id')
    	->join('clients', 'order_clients.client_id', '=', 'clients.id')
    	->join('stats', 'orders.stat_id', '=', 'stats.id')    	 
    	->where('stats.name', 'Entregado')
    	->where('orders.due',  '>' , 0)
    	->groupBy('clients.name')    	 
    	->get();

    	$details_orders = OrderClient::selectRaw("order_clients.order_id as id, clients.name, orders.date_delivery, count(order_clients.id) as articles, orders.due")
    	->join('orders', 'order_clients.order_id', '=', 'orders.id')
    	->join('clients', 'order_clients.client_id', '=', 'clients.id')
    	->join('stats', 'orders.stat_id', '=', 'stats.id')
    	->where('stats.name', 'Entregado')
    	->where('orders.due',  '>' , 0)
    	->groupBy('order_clients.order_id', 'clients.name') 
    	->orderBy('orders.due','desc')   	 
    	->get();


    	return view('admin.dashboard', compact('orders', 'details_orders'));
    }

    public function pendientes_entregas()
    {
    	$orders = OrderClient::selectRaw("clients.name as name, count(distinct(order_clients.order_id)) as data")
    	->join('orders', 'order_clients.order_id', '=', 'orders.id')
    	->join('clients', 'order_clients.client_id', '=', 'clients.id')
    	->join('stats', 'orders.stat_id', '=', 'stats.id')
    	->where('stats.name', 'Pendiente de Entrega')    	 
    	->groupBy('order_clients.client_id')    	 
    	->get();

    	$details_orders = OrderClient::selectRaw("order_clients.order_id as id, clients.name, orders.date_delivery, count(order_clients.id) as articles, orders.due")
    	->join('orders', 'order_clients.order_id', '=', 'orders.id')
    	->join('clients', 'order_clients.client_id', '=', 'clients.id')
    	->join('stats', 'orders.stat_id', '=', 'stats.id')
    	->where('stats.name', 'Pendiente de Entrega')    	 
    	->orderBy('orders.date_delivery')
    	->groupBy('order_clients.order_id', 'clients.name')
    	->get();

    	return view('admin.pendientes_entregas', compact('orders', 'details_orders'));
    }

    public function ventas(Request $request){

        $count_publicsales = PublicSale::count();

        $orders = Order::selectRaw("monthname(orders.created_at) as name, sum(orders.cost) as data")
        ->whereIn('orders.stat_id', ['1', '3'])        
        ->where('orders.created_at', '<=', \DB::raw("last_day(now())"))
        ->where('orders.created_at', '>', \DB::raw("date_sub(last_day(now()), interval 12 month)"))
        ->orderBy('name')
        ->groupBy("name")    	 
        ->get();

        $keyword = $request->get('search');

        if (!empty($keyword)) {
            $orders_list = OrderClient::selectRaw("order_clients.order_id as id, clients.name, orders.date_delivery, count(order_clients.id) as articles, orders.due, orders.cost, stats.name as state_name, orders.advance, orders.type_pay")
            ->join('orders', 'order_clients.order_id', '=', 'orders.id')
            ->join('clients', 'order_clients.client_id', '=', 'clients.id')
            ->join('stats', 'orders.stat_id', '=', 'stats.id')
            ->whereIn('stats.name', ['Entregado', 'Pendiente de Entrega'])        
            ->where('clients.name', 'LIKE', "%$keyword%")
            ->orderBy('orders.date_delivery')
            ->groupBy('order_clients.order_id', 'clients.name')        
            ->get();
        } else {
            $orders_list = OrderClient::selectRaw("order_clients.order_id as id, clients.name, orders.date_delivery, count(order_clients.id) as articles, orders.due, orders.cost, stats.name as state_name, orders.advance, orders.type_pay")
            ->join('orders', 'order_clients.order_id', '=', 'orders.id')
            ->join('clients', 'order_clients.client_id', '=', 'clients.id')
            ->join('stats', 'orders.stat_id', '=', 'stats.id')
            ->whereIn('stats.name', ['Entregado', 'Pendiente de Entrega'])        
            ->orderBy('orders.date_delivery')
            ->groupBy('order_clients.order_id', 'clients.name')        
            ->get();
        }

        return view('admin.ventas', compact('orders', 'orders_list', 'count_publicsales'));
    }

    public function ventas_publico(Request $request){

        $public_sales = PublicSale::join('order_clients', 'order_clients.client_id', '=', 'public_sales.client_id')
        ->distinct('order_clients.order_id')
        ->pluck('order_clients.order_id');

        $orders = Order::selectRaw("monthname(orders.created_at) as name, sum(orders.cost) as data")        
        ->whereIn('orders.stat_id', ['1', '3'])  
        ->whereIn('orders.id', $public_sales)      
        ->where('orders.created_at', '<=', \DB::raw("last_day(now())"))
        ->where('orders.created_at', '>', \DB::raw("date_sub(last_day(now()), interval 12 month)"))        
        ->orderBy('name')
        ->groupBy("name")        
        ->get();

        $keyword = $request->get('search');

        if (!empty($keyword)) {
            $orders_list = OrderClient::selectRaw("order_clients.order_id as id, clients.name, orders.date_delivery, count(order_clients.id) as articles, orders.due, orders.cost, stats.name as state_name, orders.advance, orders.type_pay")
            ->join('orders', 'order_clients.order_id', '=', 'orders.id')
            ->join('clients', 'order_clients.client_id', '=', 'clients.id')
            ->join('stats', 'orders.stat_id', '=', 'stats.id')
            ->whereIn('stats.name', ['Entregado', 'Pendiente de Entrega'])        
            ->whereIn('orders.id', $public_sales)
            ->where('clients.name', 'LIKE', "%$keyword%")
            ->orderBy('orders.date_delivery')
            ->groupBy('order_clients.order_id', 'clients.name')        
            ->get();
        } else {
            $orders_list = OrderClient::selectRaw("order_clients.order_id as id, clients.name, orders.date_delivery, count(order_clients.id) as articles, orders.due, orders.cost, stats.name as state_name, orders.advance, orders.type_pay")
            ->join('orders', 'order_clients.order_id', '=', 'orders.id')
            ->join('clients', 'order_clients.client_id', '=', 'clients.id')
            ->join('stats', 'orders.stat_id', '=', 'stats.id')
            ->whereIn('stats.name', ['Entregado'])        
            ->whereIn('orders.id', $public_sales)
            ->orderBy('orders.date_delivery')
            ->groupBy('order_clients.order_id', 'clients.name')        
            ->get();
        }

        return view('admin.ventas_publico', compact('orders', 'orders_list'));
    }

    public function abono($id){
    	$order = Order::join('order_clients', 'orders.id', '=', 'order_clients.order_id')
    	->with('stat')->with('order_clients')
    	->select('orders.*', 'order_clients.client_id')        
    	->findOrFail($id);


    	$client = Client::findOrFail($order->client_id);

    	$products = Product::select('id', 'name')->where('is_active', '<>' , false)
    	->orderBy('name', 'asc');

    	$products = OrderClient::
    	join('products', 'order_clients.product_id', '=', 'products.id')
    	->where('order_id', '=', $order->id)
    	->select('order_clients.*', 'products.name')
    	->get();

    	return view('admin.abono', compact('order', 'client', 'products'));
    }

    public function abono_set(Request $request, $id){
    	$this->validate($request, [        
    		'advance' => 'required'         
    	]);

    	$order = Order::findOrFail($id);

    	$order ->update(['advance' => (int)$order->advance + (int)$request['advance'], 'due' => (int)$order->due - (int)$request['advance']]);

    	return redirect('admin')->with('flash_message', 'Orden Actualizada!');
    	
    }

    public function tickets(){

        return view('admin.tickets');
        
    }

    public function inventario(Request $request){

       $chart_request = OrderClient::selectRaw("products.name as name, sum(order_clients.quantity) as data")
       ->join('products', 'order_clients.product_id', '=', 'products.id')        
       ->groupBy("name")        
       ->orderBy('data', 'desc')
       ->limit(20)
       ->get();        


       $warehouses = Warehouse::where('is_active', '=', true)->orderBy('name')->get();


       $keyword = $request->get('search');

       if (!empty($keyword)) {
        $inventory = Inventory::selectRaw("products.name as name, sum(inventories.quantity) as quantity")
        ->join('products', 'inventories.product_id', '=', 'products.id')
        ->where('products.name', 'LIKE', "%$keyword%")
        ->groupBy('name')        
        ->orderBy('quantity')
        ->get(); 

        $products = Product::where('name', 'LIKE', "%$keyword%")->orderBy('name')->get();

        $inventories = Inventory::with('warehouse', 'product')
        ->where('products.name', 'LIKE', "%$keyword%")
        ->orderBy('quantity', 'asc')
        ->get();

    }else{
       $inventory = Inventory::selectRaw("products.name as name, sum(inventories.quantity) as quantity")
       ->join('products', 'inventories.product_id', '=', 'products.id')
       ->groupBy('name')        
       ->orderBy('quantity', 'asc')
       ->get(); 

       $products = Product::orderBy('name')->get();

       $inventories = Inventory::with('warehouse', 'product')->orderBy('quantity', 'asc')->get();
   }

   return view('admin.inventario', compact('inventory', 'chart_request', 'inventories', 'warehouses', 'products'));

}


}
