<?php

namespace App\Http\Controllers\TypeClient;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\TypeClient;
use App\LogWorkFlow;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

class TypeClientsController extends Controller
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
            $typeclients = TypeClient::where('name', 'LIKE', "%$keyword%")
            ->orWhere('description', 'LIKE', "%$keyword%")
            ->orWhere('is_active', 'LIKE', "%$keyword%")
            ->latest()->paginate($perPage);
        } else {
            $typeclients = TypeClient::latest()->paginate($perPage);
        }

        return view('type_client.type-clients.index', compact('typeclients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('type_client.type-clients.create');
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
         'is_active' => 'required'
     ]);
        $requestData = $request->all();
        
        $tipo_c = TypeClient::create($requestData);

        $lwf = new LogWorkFlow;
        $lwf->controller_name = Route::current()->action['controller'];
        $lwf->action = 'CREAR';
        $lwf->page = Route::current()->uri;
        $lwf->register_id = $tipo_c->id;
        $lwf->user_id = auth()->user()->id;
        $lwf->info1 = $tipo_c->toJson(JSON_PRETTY_PRINT);
        $lwf->save();

        return redirect('type_client/type-clients')->with('flash_message', 'TypeClient added!');
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
        $typeclient = TypeClient::findOrFail($id);

        return view('type_client.type-clients.show', compact('typeclient'));
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
        $typeclient = TypeClient::findOrFail($id);

        return view('type_client.type-clients.edit', compact('typeclient'));
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
        
        $typeclient = TypeClient::findOrFail($id);
        $record_temp = TypeClient::find($id);
        $typeclient->update($requestData);


        $lwf = new LogWorkFlow;
        $lwf->controller_name = Route::current()->action['controller'];
        $lwf->action = 'ACTUALIZAR';
        $lwf->page = Route::current()->uri;
        $lwf->register_id = $typeclient->id;
        $lwf->user_id = auth()->user()->id;
        $lwf->info1 = $typeclient->toJson(JSON_PRETTY_PRINT);
        $lwf->info2 = $record_temp->toJson(JSON_PRETTY_PRINT);
        $lwf->save();

        return redirect('type_client/type-clients')->with('flash_message', 'TypeClient updated!');
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
        $record_temp = TypeClient::find($id);

        TypeClient::destroy($id);
        
        $lwf = new LogWorkFlow;
        $lwf->controller_name = Route::current()->action['controller'];
        $lwf->action = 'ELIMINAR';
        $lwf->page = Route::current()->uri;
        $lwf->register_id = $record_temp->id;
        $lwf->user_id = auth()->user()->id;
        $lwf->info1 = $record_temp->toJson(JSON_PRETTY_PRINT);        
        $lwf->save();

        return redirect('type_client/type-clients')->with('flash_message', 'TypeClient deleted!');
    }
}
