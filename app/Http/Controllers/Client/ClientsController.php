<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\TypeClient;
use App\LogWorkFlow;
use App\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ClientsController extends Controller
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
            $clients = Client::with('type_client')->where('name', 'LIKE', "%$keyword%")
                ->orWhere('contact', 'LIKE', "%$keyword%")
                ->orWhere('adress', 'LIKE', "%$keyword%")
                ->orWhere('email', 'LIKE', "%$keyword%")
                ->orWhere('telephone1', 'LIKE', "%$keyword%")
                ->orWhere('ext1', 'LIKE', "%$keyword%")
                ->orWhere('telephone2', 'LIKE', "%$keyword%")
                ->orWhere('type_business', 'LIKE', "%$keyword%")
                ->orWhere('rfc', 'LIKE', "%$keyword%")
                ->orWhere('email2', 'LIKE', "%$keyword%")
                ->orWhere('contact_position', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $clients = Client::with('type_client')->latest()->paginate($perPage);
        }

        return view('client.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $t_c = TypeClient::select('id', 'name')->where('is_active', '=' , true)->get();
        $t_c = $t_c->pluck('name', 'id');

        return view('client.clients.create', compact('t_c'));
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
			'telephone1' => 'required'
            			
		]);
        $requestData = $request->all();
        
        $client = Client::create($requestData);

        $lwf = new LogWorkFlow;
        $lwf->controller_name = Route::current()->action['controller'];
        $lwf->action = 'CREAR';
        $lwf->page = Route::current()->uri;
        $lwf->register_id = $client->id;
        $lwf->user_id = auth()->user()->id;
        $lwf->info1 = $client->toJson(JSON_PRETTY_PRINT);
        $lwf->save();

        return redirect('client/clients')->with('flash_message', 'Cliente agregado!');
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
        $client = Client::with('type_client')->findOrFail($id);

        return view('client.clients.show', compact('client'));
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
       

        $client = Client::with('type_client')->findOrFail($id);
        
        $t_c = TypeClient::select('id', 'name')->where('is_active', '=' , true)->get();
        $t_c = $t_c->pluck('name', 'id');
        

        return view('client.clients.edit', compact('client', 't_c'));
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
            'telephone1' => 'required'
            
		]);
        $requestData = $request->all();
        
        $client = Client::findOrFail($id);
        $client_temp = Client::find($id);
        $client->update($requestData);

        $lwf = new LogWorkFlow;
        $lwf->controller_name = Route::current()->action['controller'];
        $lwf->action = 'ACTUALIZAR';
        $lwf->page = Route::current()->uri;
        $lwf->register_id = $client->id;
        $lwf->user_id = auth()->user()->id;
        $lwf->info1 = $client->toJson(JSON_PRETTY_PRINT);
        $lwf->info2 = $client_temp->toJson(JSON_PRETTY_PRINT);
        $lwf->save();

        return redirect('client/clients')->with('flash_message', 'Cliente actualizado!');
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
        $client = Client::find($id);
        Client::destroy($id);

        $lwf = new LogWorkFlow;
        $lwf->controller_name = Route::current()->action['controller'];
        $lwf->action = 'ELIMINAR';
        $lwf->page = Route::current()->uri;
        $lwf->register_id = $client->id;
        $lwf->user_id = auth()->user()->id;
        $lwf->info1 = $client->toJson(JSON_PRETTY_PRINT);        
        $lwf->save();

        return redirect('client/clients')->with('flash_message', 'Cliente eliminado!');
    }
}
