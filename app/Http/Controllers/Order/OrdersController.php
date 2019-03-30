<?php

namespace App\Http\Controllers\Order;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Warehouse;
use App\Inventory;
use App\Order;
use App\OrderClient;
use App\Client;
use App\PublicSale;
use App\Product;
use App\Stat;
use App\User;
use App\LogWorkFlow;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;


        if (!empty($keyword)) {
            $orders = Order::with('stat', 'order_clients', 'user')
            ->join('stats', 'orders.stat_id', '=', 'stats.id')
            ->join('order_clients', 'order_clients.order_id', '=', 'orders.id')    
            ->join('clients', 'order_clients.client_id', '=', 'clients.id')        
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('date_delivery', 'LIKE', "%$keyword%")
            ->orWhere('date_delivery', 'LIKE', "%$keyword%")
            ->orWhere('clients.name', 'LIKE', "%$keyword%")
            ->orWhere('users.name', 'LIKE', "%$keyword%")
            ->orWhere('due', 'LIKE', "%$keyword%")
            ->orWhere('stats.name', 'LIKE', "%$keyword%");
            
        } else {
           $orders = Order::with('stat', 'order_clients', 'user')
           ->join('stats', 'orders.stat_id', '=', 'stats.id')
           ->join('order_clients', 'order_clients.order_id', '=', 'orders.id')
           ->join('users', 'orders.user_id', '=', 'users.id');

       }

       if (auth()->user()->roles[0]->name == 'Todo' || auth()->user()->roles[0]->name == 'Admin'){
         $orders= $orders->distinct('order.id')            
         ->select('orders.*', 'stats.name as state_name', 'order_clients.client_id as client')
         ->latest()            
         ->paginate($perPage);


     }else{
        $orders= $orders->where('orders.user_id', '=', auth()->user()->id)
        ->distinct('order.id')
        ->select('orders.*', 'stats.name as state_name', 'order_clients.client_id as client')
        ->latest()            
        ->paginate($perPage);}

        return view('order.orders.index', compact('orders'));
    }

    public function reportecompleto(Request $request)
    {
        $keyword = $request->get('search');

        if (!empty($keyword)) {
            $orders = Order::with('stat', 'order_clients', 'user')
            ->join('stats', 'orders.stat_id', '=', 'stats.id')
            ->join('order_clients', 'order_clients.order_id', '=', 'orders.id')    
            ->join('clients', 'order_clients.client_id', '=', 'clients.id')        
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('date_delivery', 'LIKE', "%$keyword%")
            ->orWhere('date_delivery', 'BETWEEN', "%$keyword%")
            ->orWhere('clients.name', 'LIKE', "%$keyword%")
            ->orWhere('users.name', 'LIKE', "%$keyword%")
            ->orWhere('due', 'LIKE', "%$keyword%")
            ->orWhere('stats.name', 'LIKE', "%$keyword%");

        } else {
           $orders = Order::with('stat', 'order_clients', 'user')
           ->join('stats', 'orders.stat_id', '=', 'stats.id')
           ->join('order_clients', 'order_clients.order_id', '=', 'orders.id')
           ->join('users', 'orders.user_id', '=', 'users.id');

       }

       if (auth()->user()->roles[0]->name == 'Todo' || auth()->user()->roles[0]->name == 'Admin'){
         $orders= $orders->distinct('order.id')            
         ->select('orders.*', 'stats.name as state_name', 'order_clients.client_id as client')
         ->latest()            
         ->paginate($perPage);


     }else{
        $orders= $orders->where('orders.user_id', '=', auth()->user()->id)
        ->distinct('order.id')
        ->select('orders.*', 'stats.name as state_name', 'order_clients.client_id as client')
        ->latest()            
        ->paginate($perPage);}

        return view('order.orders.index', compact('orders'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
     $order = null;
     $stats = Stat::select('id', 'name')->where('is_active', '<>' , false)
     ->orderBy('name', 'asc')->get();

     $public_sales_client = null;

     $count_publicsales = PublicSale::count();
     if($count_publicsales == 0){
        $clients = Client::select('id', 'name')->where('is_active', '<>' , false)
        ->orderBy('name', 'asc')->get();
    }else{
        $public_client = PublicSale::first(); 
        $clients = Client::select('id', 'name')->where('is_active', '<>' , false)
        ->where('id', '!=', $public_client->client_id)
        ->orderBy('name', 'asc')->get();      
    }




    $products = Product::join('inventories', 'products.id', '=', 'inventories.product_id')
    ->selectRaw("CONCAT(products.name, '   Disponibles: ', CONVERT(SUM(inventories.quantity) USING utf8)) as name, products.id as id")
    ->where('inventories.quantity', '>', 0)
    ->groupBy('products.name', 'inventories.product_id')
    ->orderBy('products.name', 'asc')->get();

    $stats = $stats->pluck('name', 'id');
    $clients = $clients->pluck('name', 'id');
    $products = $products->pluck('name', 'id');

    return view('order.orders.create', compact('order','stats','clients','products', 'public_sales_client'));
}

public function venta_publico()
{

    $count_publicsales = PublicSale::count();
    if($count_publicsales == 0){
        return redirect('order/orders')->with('flash_message', 'No hay cliente vinculado como venta al público');
    }

    $public_sales_client = PublicSale::first();

    $order = null;
    $stats = Stat::select('id', 'name')->where('is_active', '<>' , false)
    ->orderBy('name', 'asc')->get();


    $clients = Client::select('id', 'name')->where('is_active', '<>' , false)
    ->orderBy('name', 'asc')->get();

    $products = Product::join('inventories', 'products.id', '=', 'inventories.product_id')
    ->selectRaw("CONCAT(products.name, '   Disponibles: ', CONVERT(SUM(inventories.quantity) USING utf8)) as name, products.id as id")
    ->where('inventories.quantity', '>', 0)
    ->groupBy('products.name', 'inventories.product_id')
    ->orderBy('products.name', 'asc')->get();

    $stats = $stats->pluck('name', 'id');
    $clients = $clients->pluck('name', 'id');
    $products = $products->pluck('name', 'id');

    return view('order.orders.venta_publico', compact('order','stats','public_sales_client','products'));
}

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {


        $this->validate($request, [
           'stat_id' => 'required',
           'date_delivery' => 'required',         
           'cost' => 'required',
           'type_pay' => 'required',                    
           'client_id' => 'required',
           'product_id' => 'required|array|not_in:0',
           'quantity' => 'required|array|not_in:0'           
       ]);

        $requestData = $request->all();

        $order = Order::create($requestData);
        $order->user_id = auth()->user()->id;
        $order->save();
        $resagado = 0;
        $loop = false;
        

        foreach ($request['product_id'] as $key => $item){
            $product = Product::find((int)$item);
            $cost_product = ((int)$product->price_retail * (int)$request['quantity'][$key]);
            $order->order_clients()->create(['order_id'=>$order->id, 'product_id'=>$item, 'quantity'=>$request['quantity'][$key], 'cost'=>$cost_product, 'client_id'=>$request['client_id']]);

            $list_w = Warehouse::orderBy('priority', 'asc')->get();
            foreach ($list_w as $w) {
                $inventario = Inventory::where('warehouse_id', '=', $w->id)
                ->where('product_id', '=', $item)->get();
                foreach ($inventario as $i) {
                    if($loop == false){
                        $resagado = (int)$request['quantity'][$key];
                        $loop = true;
                    }

                    $cantidad_wi = (int)$i->quantity;
                    $cantidad_menos_resagado = $cantidad_wi - $resagado;
                    
                    if($cantidad_menos_resagado >= 0){
                        $i->quantity = $cantidad_menos_resagado;
                        $i->save();
                        $resagado = 0;
                    }else{
                      $resagado = $resagado - $cantidad_wi;
                      $i->quantity = 0;
                      $i->save();
                  }
                  
              };
          };

          if((int)$resagado > 0){

            $ware_principal = Warehouse::orderBy('priority', 'asc')->first();
            $inventario_principal = Inventory::where('warehouse_id', '=', $ware_principal->id)
            ->where('product_id', '=', $product->id)->first();
            if(empty($inventario_principal)){
                $new_i = Inventory::create(['warehouse_id'=>$ware_principal->id, 'product_id'=>$product->id, 'quantity'=> (0 - (int)$resagado) , 'is_active'=> true]);
            }else{
                $inventario_principal->quantity =  $inventario_principal->quantity - $resagado;
                $inventario_principal->save();
            }
        }
    };



    $public_sales_client = PublicSale::first();
        //dd([(int)$public_sales_client->client_id, (int)$request['client_id']]);
    $lwf = new LogWorkFlow;
    $lwf->controller_name = Route::current()->action['controller'];
    $lwf->action = 'CREAR';
    $lwf->page = Route::current()->uri;
    $lwf->register_id = $order->id;
    $lwf->user_id = auth()->user()->id;
    $lwf->info1 = $order->toJson(JSON_PRETTY_PRINT);


    if((int)$public_sales_client->client_id == (int)$request['client_id']){
        $order->due = '0';
        $order->advance = $order->cost;
        $order->save();

        $lwf->info1 = $order->toJson(JSON_PRETTY_PRINT);
        $lwf->save();
        return redirect('/ticket/index.php?order='.$order->id)->with('flash_message', 'Venta Finalizada, Imprimiendo Ticket!');    
    }else{

        $lwf->save();
        return redirect('order/orders')->with('flash_message', 'Orden Agregada!');    
    }

}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $order = Order::join('order_clients', 'orders.id', '=', 'order_clients.order_id')
        ->join('users', 'orders.user_id', '=', 'users.id')
        ->with('stat')->with('order_clients')->with('user')
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

        

        return view('order.orders.show', compact('order', 'client', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $order = Order::join('order_clients', 'orders.id', '=', 'order_clients.order_id')
        ->join('users', 'orders.user_id', '=', 'users.id')
        ->with('stat')->with('order_clients')->with('user')
        ->select('orders.*', 'order_clients.client_id')        
        ->findOrFail($id);
        
        $public_sales_client = null;
        
        $stats = Stat::select('id', 'name')->where('is_active', '<>' , false)
        ->orderBy('name', 'asc')->get();
        
        $clients = Client::select('id', 'name')->where('id', '=' , $order->client_id)
        ->orderBy('name', 'asc')->get();

        $products = Product::join('inventories', 'products.id', '=', 'inventories.product_id')
        ->selectRaw("CONCAT(products.name, '   Disponibles: ', inventories.quantity) as name, products.id as id")
        ->where('inventories.quantity', '>', 0)
        ->orderBy('products.name', 'asc')->get();

        $stats = $stats->pluck('name', 'id');
        $clients = $clients->pluck('name', 'id');
        $products = $products->pluck('name', 'id');

        return view('order.orders.edit', compact('order','stats','clients','products', 'public_sales_client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
           'stat_id' => 'required',
           'date_delivery' => 'required',
           'cost' => 'required',
           'type_pay' => 'required',
           'advance' => 'required',
           'due' => 'required'
       ]);
        $requestData = $request->all();        
        $order = Order::findOrFail($id);
        $record_temp = Order::find($id);
        $order->update($requestData);


        if($request['product_id'][0] != "0"){
            foreach ($request['product_id'] as $key => $item){
                $product = Product::find((int)$item);
                $cost_product = ((int)$product->price_retail * (int)$request['quantity'][$key]);
                $order->order_clients()->create(['order_id'=>$order->id, 'product_id'=>$item, 'quantity'=>$request['quantity'][$key], 'cost'=>$cost_product, 'client_id'=>$request['client_id']]);
            };
        }


        $lwf = new LogWorkFlow;
        $lwf->controller_name = Route::current()->action['controller'];
        $lwf->action = 'ACTUALIZAR';
        $lwf->page = Route::current()->uri;
        $lwf->register_id = $order->id;
        $lwf->user_id = auth()->user()->id;
        $lwf->info1 = $order->toJson(JSON_PRETTY_PRINT);
        $lwf->info2 = $record_temp->toJson(JSON_PRETTY_PRINT);
        $lwf->save();

        return redirect('order/orders')->with('flash_message', 'Orden Actualizada!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        
        $record_temp = Order::find($id);
        $record_temp2 = OrderClient::where('order_id', $id)->get();

        $record_temp2 = json_decode($record_temp2, true);
        $record_temp2['model'] = 'OrderClient';
        $record_temp2 = json_encode($record_temp2, JSON_PRETTY_PRINT);        

        OrderClient::where('order_id', $id)->delete();
        Order::destroy($id);



        $lwf = new LogWorkFlow;
        $lwf->controller_name = Route::current()->action['controller'];
        $lwf->action = 'ELIMINAR';
        $lwf->page = Route::current()->uri;
        $lwf->register_id = $record_temp->id;
        $lwf->user_id = auth()->user()->id;
        $lwf->info1 = $record_temp->toJson(JSON_PRETTY_PRINT);        
        $lwf->info2 = $record_temp2;        
        $lwf->save();

        return redirect('order/orders')->with('flash_message', 'Orden Eliminada!');
    }
}
