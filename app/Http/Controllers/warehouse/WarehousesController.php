<?php

namespace App\Http\Controllers\warehouse;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Warehouse;
use App\LogWorkFlow;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

class WarehousesController extends Controller
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
            $warehouses = Warehouse::where('name', 'LIKE', "%$keyword%")
            ->orWhere('description', 'LIKE', "%$keyword%")
            ->orWhere('is_active', 'LIKE', "%$keyword%")
            ->orWhere('quantity', 'LIKE', "%$keyword%")
            ->latest()->paginate($perPage);
        } else {
            $warehouses = Warehouse::latest()->paginate($perPage);
        }

        return view('warehouse.warehouses.index', compact('warehouses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('warehouse.warehouses.create');
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
         'name' => 'required',
         'description' => 'required',
         'is_active' => 'required',
         'priority' => 'required'
     ]);
        $requestData = $request->all();
        
        $almacen = Warehouse::create($requestData);

        $lwf = new LogWorkFlow;
        $lwf->controller_name = Route::current()->action['controller'];
        $lwf->action = 'CREAR';
        $lwf->page = Route::current()->uri;
        $lwf->register_id = $almacen->id;
        $lwf->user_id = auth()->user()->id;
        $lwf->info1 = $almacen->toJson(JSON_PRETTY_PRINT);
        $lwf->save();

        return redirect('warehouse/warehouses')->with('flash_message', 'Almacén agregado!');
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
        $warehouse = Warehouse::findOrFail($id);

        return view('warehouse.warehouses.show', compact('warehouse'));
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
        $warehouse = Warehouse::findOrFail($id);

        return view('warehouse.warehouses.edit', compact('warehouse'));
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
         'name' => 'required',
         'description' => 'required',
         'is_active' => 'required'
     ]);
        $requestData = $request->all();
        
        $warehouse = Warehouse::findOrFail($id);
        $record_temp = Warehouse::find($id);
        $warehouse->update($requestData);


        $lwf = new LogWorkFlow;
        $lwf->controller_name = Route::current()->action['controller'];
        $lwf->action = 'ACTUALIZAR';
        $lwf->page = Route::current()->uri;
        $lwf->register_id = $warehouse->id;
        $lwf->user_id = auth()->user()->id;
        $lwf->info1 = $warehouse->toJson(JSON_PRETTY_PRINT);
        $lwf->info2 = $record_temp->toJson(JSON_PRETTY_PRINT);
        $lwf->save();

        return redirect('warehouse/warehouses')->with('flash_message', 'Almacén Actualizado!');
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
        $record_temp = Warehouse::find($id);
        
        Warehouse::destroy($id);


        $lwf = new LogWorkFlow;
        $lwf->controller_name = Route::current()->action['controller'];
        $lwf->action = 'ELIMINAR';
        $lwf->page = Route::current()->uri;
        $lwf->register_id = $record_temp->id;
        $lwf->user_id = auth()->user()->id;
        $lwf->info1 = $record_temp->toJson(JSON_PRETTY_PRINT);        
        $lwf->save();

        return redirect('warehouse/warehouses')->with('flash_message', 'Almacén eliminado!');
    }
}
