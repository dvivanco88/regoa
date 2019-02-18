<?php

namespace App\Http\Controllers\Order;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Order;
use App\OrderClient;
use App\Client;
use App\Product;
use App\Stat;
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
            $orders = Order::with('stat', 'order_clients')
            ->join('stats', 'orders.stat_id', '=', 'stats.id')
            ->join('order_clients', 'order_clients.order_id', '=', 'orders.id')    
            ->join('clients', 'order_clients.client_id', '=', 'clients.id')        
            ->orWhere('date_delivery', 'LIKE', "%$keyword%")
            ->orWhere('date_delivery', 'LIKE', "%$keyword%")
            ->orWhere('clients.name', 'LIKE', "%$keyword%")
            ->orWhere('due', 'LIKE', "%$keyword%")
            ->orWhere('stats.name', 'LIKE', "%$keyword%")
            ->distinct('order.id')            
            ->select('orders.*', 'stats.name as state_name', 'order_clients.client_id as client')
            ->latest()            
            ->paginate($perPage);
        } else {
             $orders = Order::with('stat', 'order_clients')
            ->join('stats', 'orders.stat_id', '=', 'stats.id')
            ->join('order_clients', 'order_clients.order_id', '=', 'orders.id')
            ->distinct('order.id')
            ->select('orders.*', 'stats.name as state_name', 'order_clients.client_id as client')
            ->latest()            
            ->paginate($perPage);
        }

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


       $clients = Client::select('id', 'name')->where('is_active', '<>' , false)
       ->orderBy('name', 'asc')->get();

       $products = Product::join('inventories', 'products.id', '=', 'inventories.product_id')
       ->selectRaw("CONCAT(products.name, '   Disponibles: ', CONVERT(SUM(inventories.quantity) USING utf8)) as name, products.id as id")
       ->where('inventories.quantity', '>=', 0)
       ->groupBy('products.name', 'inventories.product_id')
       ->orderBy('products.name', 'asc')->get();

       $stats = $stats->pluck('name', 'id');
       $clients = $clients->pluck('name', 'id');
       $products = $products->pluck('name', 'id');

       return view('order.orders.create', compact('order','stats','clients','products'));
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
        //dd($request);

        $this->validate($request, [
         'stat_id' => 'required',
         'date_delivery' => 'required',         
         'cost' => 'required',
         'type_pay' => 'required',         
         'advance' => 'required',
         'due' => 'required',
         'client_id' => 'required',
         'product_id' => 'required|array|not_in:0',
         'quantity' => 'required|array|not_in:0'
     ]);

        $requestData = $request->all();

        $order = Order::create($requestData);
        
        foreach ($request['product_id'] as $key => $item){
            $product = Product::find((int)$item);
            $cost_product = ((int)$product->price_retail * (int)$request['quantity'][$key]);
            $order->order_clients()->create(['order_id'=>$order->id, 'product_id'=>$item, 'quantity'=>$request['quantity'][$key], 'cost'=>$cost_product, 'client_id'=>$request['client_id']]);
        };
        
        
        

        return redirect('order/orders')->with('flash_message', 'Order added!');
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
        ->with('stat')->with('order_clients')
        ->select('orders.*', 'order_clients.client_id')        
        ->findOrFail($id);
        
        
        $stats = Stat::select('id', 'name')->where('is_active', '<>' , false)
        ->orderBy('name', 'asc')->get();
        
        $clients = Client::select('id', 'name')->where('id', '=' , $order->client_id)
        ->orderBy('name', 'asc')->get();

        $products = Product::join('inventories', 'products.id', '=', 'inventories.product_id')
       ->selectRaw("CONCAT(products.name, '   Disponibles: ', inventories.quantity) as name, products.id as id")
       ->where('inventories.quantity', '>=', 0)
       ->orderBy('products.name', 'asc')->get();

        $stats = $stats->pluck('name', 'id');
        $clients = $clients->pluck('name', 'id');
        $products = $products->pluck('name', 'id');

        return view('order.orders.edit', compact('order','stats','clients','products'));
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
        $order->update($requestData);


        if($request['product_id'][0] != "0"){
            foreach ($request['product_id'] as $key => $item){
                $product = Product::find((int)$item);
                $cost_product = ((int)$product->price_retail * (int)$request['quantity'][$key]);
                $order->order_clients()->create(['order_id'=>$order->id, 'product_id'=>$item, 'quantity'=>$request['quantity'][$key], 'cost'=>$cost_product, 'client_id'=>$request['client_id']]);
            };
        }

        return redirect('order/orders')->with('flash_message', 'Order updated!');
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
        Order::destroy($id);

        return redirect('order/orders')->with('flash_message', 'Order deleted!');
    }
}
