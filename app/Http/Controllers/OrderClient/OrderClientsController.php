<?php

namespace App\Http\Controllers\OrderClient;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\OrderClient;
use App\Order;
use Illuminate\Http\Request;

class OrderClientsController extends Controller
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
            $orderclients = OrderClient::where('client_id', 'LIKE', "%$keyword%")
                ->orWhere('product_id', 'LIKE', "%$keyword%")
                ->orWhere('quantity', 'LIKE', "%$keyword%")
                ->orWhere('cost', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $orderclients = OrderClient::latest()->paginate($perPage);
        }

        return view('order_client.order-clients.index', compact('orderclients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('order_client.order-clients.create');
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
			'client_id' => 'required',
			'product_id' => 'required',
			'quantity' => 'required',
			'cost' => 'required'
		]);
        $requestData = $request->all();
        
        OrderClient::create($requestData);

        return redirect('order_client/order-clients')->with('flash_message', 'OrderClient added!');
    }

    public function delete_product_edit(Request $request){
        $order_id = OrderClient::find((int)$request['id']);
        $order = Order::find($order_id->order_id);
        
        $order->cost = (string)((int)$order->cost - (int)$order_id->cost);
        $order->due = (string)((int)$order->cost - (int)$order->advance);
        $order->save();
        OrderClient::destroy($request['id']);
        return response()->json('eliminado');
        
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
        $orderclient = OrderClient::findOrFail($id);

        return view('order_client.order-clients.show', compact('orderclient'));
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
        $orderclient = OrderClient::findOrFail($id);

        return view('order_client.order-clients.edit', compact('orderclient'));
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
			'client_id' => 'required',
			'product_id' => 'required',
			'quantity' => 'required',
			'cost' => 'required'
		]);
        $requestData = $request->all();
        
        $orderclient = OrderClient::findOrFail($id);
        $orderclient->update($requestData);

        return redirect('order_client/order-clients')->with('flash_message', 'OrderClient updated!');
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
        OrderClient::destroy($id);

        return redirect('order_client/order-clients')->with('flash_message', 'OrderClient deleted!');
    }
}
