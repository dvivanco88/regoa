<?php

namespace App\Http\Controllers\warehouse;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Warehouse;
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
        
        Warehouse::create($requestData);

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
        $warehouse->update($requestData);

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
        Warehouse::destroy($id);

        return redirect('warehouse/warehouses')->with('flash_message', 'Almacén eliminado!');
    }
}
