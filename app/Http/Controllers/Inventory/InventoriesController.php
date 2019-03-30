<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Inventory;
use App\Warehouse;
use App\Product;
use App\LogWorkFlow;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

class InventoriesController extends Controller
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

        $inventories = Inventory::with('warehouse', 'product')->latest()->paginate($perPage);
        $warehouses = Warehouse::where('is_active', '=', true)->orderBy('name')->get();

        if (!empty($keyword)) {
            $products = Product::where('name', 'LIKE', "%$keyword%")->orderBy('name')->get();
        } else {                
            $products = Product::orderBy('name')->get();
        }           


        return view('inventory.inventories.index', compact('inventories', 'warehouses', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {   

        $almacenes = Warehouse::select('id', 'name')->where('is_active', '<>' , false)->get();
        $almacenes = $almacenes->pluck('name', 'id');

        $productos = Product::select('id', 'name')->where('is_active', '<>' , false)->get();
        $productos = $productos->pluck('name', 'id');

        $warehouse_id = $request->get('warehouse_id');
        $product_id = $request->get('product_id');



        return view('inventory.inventories.create', compact('almacenes', 'productos', 'warehouse_id', 'product_id'));
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
         'warehouse_id' => 'required',
         'product_id' => 'required',
         'quantity' => 'required',
         'is_active' => 'required'
     ]);
        $requestData = $request->all();
        
        $inventario = Inventory::create($requestData);

        $lwf = new LogWorkFlow;
        $lwf->controller_name = Route::current()->action['controller'];
        $lwf->action = 'CREAR';
        $lwf->page = Route::current()->uri;
        $lwf->register_id = $inventario->id;
        $lwf->user_id = auth()->user()->id;
        $lwf->info1 = $inventario->toJson(JSON_PRETTY_PRINT);
        $lwf->save();

        return redirect('inventory/inventories')->with('flash_message', 'Inventario agregado!');
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
        $inventory = Inventory::with('warehouse', 'product')->findOrFail($id);

        return view('inventory.inventories.show', compact('inventory'));
    }

    public function add_articles_to_inventory($id)
    {
       $inventory = Inventory::findOrFail($id);

       $almacenes = Warehouse::select('id', 'name')->where('is_active', '<>' , false)->get();
       $almacenes = $almacenes->pluck('name', 'id');

       $productos = Product::select('id', 'name')->where('is_active', '<>' , false)->get();
       $productos = $productos->pluck('name', 'id');


       $warehouse_id = $inventory->warehouse_id;
       $product_id = $inventory->product_id;



       return view('inventory.inventories.add_articles_to_inventory', compact('inventory', 'almacenes', 'productos', 'warehouse_id', 'product_id'));
   }

   public function add_articles_and_inventory(Request $request)
   {
    $almacenes = Warehouse::select('id', 'name')->where('is_active', '<>' , false)->get();
    $almacenes = $almacenes->pluck('name', 'id');

    $productos = Product::select('id', 'name')->where('is_active', '<>' , false)->get();
    $productos = $productos->pluck('name', 'id');

    $warehouse_id = $request->get('warehouse_id');
    $product_id = $request->get('product_id');

    return view('inventory.inventories.add_articles_and_inventory', compact('almacenes', 'productos', 'warehouse_id', 'product_id'));        
}

public function add_store(Request $request)
{
    $this->validate($request, [
     'warehouse_id' => 'required',
     'product_id' => 'required',
     'quantity' => 'required',
     'is_active' => 'required'
 ]);
    $requestData = $request->all();

    $inventario = Inventory::create($requestData);

    $lwf = new LogWorkFlow;
    $lwf->controller_name = Route::current()->action['controller'];
    $lwf->action = 'AGREGAR INVENTARIO';
    $lwf->page = Route::current()->uri;
    $lwf->register_id = $inventario->id;
    $lwf->user_id = auth()->user()->id;
    $lwf->info1 = $inventario->toJson(JSON_PRETTY_PRINT);
    $lwf->save();

    return redirect('inventory/inventories')->with('flash_message', 'Inventario agregado!');
}

public function add_update(Request $request, $id)
{
    $this->validate($request, [
     'warehouse_id' => 'required',
     'product_id' => 'required',
     'quantity' => 'required',
     'is_active' => 'required'
 ]);

    $requestData = $request->all();

    $inventory = Inventory::findOrFail($id);
    $record_temp = Inventory::find($id);
    $inventory->update($requestData);


    $lwf = new LogWorkFlow;
    $lwf->controller_name = Route::current()->action['controller'];
    $lwf->action = 'AGREGAR INVENTARIO';
    $lwf->page = Route::current()->uri;
    $lwf->register_id = $inventory->id;
    $lwf->user_id = auth()->user()->id;
    $lwf->info1 = $inventory->toJson(JSON_PRETTY_PRINT);
    $lwf->info2 = $record_temp->toJson(JSON_PRETTY_PRINT);
    $lwf->save();

    return redirect('inventory/inventories')->with('flash_message', 'Inventario actualizado!');

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
        $inventory = Inventory::findOrFail($id);

        $almacenes = Warehouse::select('id', 'name')->where('is_active', '<>' , false)->get();
        $almacenes = $almacenes->pluck('name', 'id');

        $productos = Product::select('id', 'name')->where('is_active', '<>' , false)->get();
        $productos = $productos->pluck('name', 'id');


        $warehouse_id = $inventory->warehouse_id;
        $product_id = $inventory->product_id;

        return view('inventory.inventories.edit', compact('inventory', 'almacenes', 'productos', 'warehouse_id', 'product_id'));
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
         'warehouse_id' => 'required',
         'product_id' => 'required',
         'quantity' => 'required',
         'is_active' => 'required'
     ]);

        $requestData = $request->all();
        
        $inventory = Inventory::findOrFail($id);
        $record_temp = Inventory::find($id);
        $inventory->update($requestData);       


        $lwf = new LogWorkFlow;
        $lwf->controller_name = Route::current()->action['controller'];
        $lwf->action = 'ACTUALIZAR';
        $lwf->page = Route::current()->uri;
        $lwf->register_id = $inventory->id;
        $lwf->user_id = auth()->user()->id;
        $lwf->info1 = $inventory->toJson(JSON_PRETTY_PRINT);
        $lwf->info2 = $record_temp->toJson(JSON_PRETTY_PRINT);
        $lwf->save();
        
        return redirect('inventory/inventories')->with('flash_message', 'Inventario actualizado!');
        
        return redirect('inventory/inventories')->with('flash_message', 'Inventario actualizado!');
        
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
        $record_temp = Inventory::find($id);
        Inventory::destroy($id);

        $lwf = new LogWorkFlow;
        $lwf->controller_name = Route::current()->action['controller'];
        $lwf->action = 'ELIMINAR';
        $lwf->page = Route::current()->uri;
        $lwf->register_id = $record_temp->id;
        $lwf->user_id = auth()->user()->id;
        $lwf->info1 = $record_temp->toJson(JSON_PRETTY_PRINT);        
        $lwf->save();

        return redirect('inventory/inventories')->with('flash_message', 'Inventario eliminado!');
    }
}
