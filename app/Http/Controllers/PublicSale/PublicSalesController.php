<?php

namespace App\Http\Controllers\PublicSale;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PublicSale;
use App\Client;
use Illuminate\Http\Request;

class PublicSalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        /*$keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $publicsales = PublicSale::where('client_id', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {*/
            
            $count_publicsales = PublicSale::count();
            if ($count_publicsales == 0){
                $publicsales = PublicSale::latest()->paginate(1);
            }else{
                $publicsales = PublicSale::with('client')->latest()->paginate(1);
            }
        //}

        return view('public_sales.public-sales.index', compact('publicsales', 'count_publicsales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $clients = Client::select('id', 'name')->where('is_active', '<>' , false)
       ->orderBy('name', 'asc')->pluck('name', 'id');

        return view('public_sales.public-sales.create', compact('clients'));
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
			'client_id' => 'required'
		]);
        $requestData = $request->all();
        
        PublicSale::create($requestData);

        return redirect('public_sales/public-sales')->with('flash_message', 'Cliente Público agregado!');
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
        #$publicsale = PublicSale::findOrFail($id);
        return redirect('public_sales/public-sales');
        #return view('public_sales.public-sales.show', compact('publicsale'));
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
        $publicsale = PublicSale::findOrFail($id);

        $clients = Client::select('id', 'name')->orderBy('name', 'asc')->pluck('name', 'id');

        return view('public_sales.public-sales.edit', compact('publicsale', 'clients'));
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
			'client_id' => 'required'
		]);
        $requestData = $request->all();
        
        $publicsale = PublicSale::findOrFail($id);
        $publicsale->update($requestData);

        return redirect('public_sales/public-sales')->with('flash_message', 'Cliente Público actualizado!');
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
        #PublicSale::destroy($id);
        return redirect('public_sales/public-sales')->with('flash_message', 'No es posible eliminar Cliente Público!');
        #return redirect('public_sales/public-sales')->with('flash_message', 'Cliente Público eliminado!');
    }
}
