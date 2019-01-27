<?php

namespace App\Http\Controllers\TypeClient;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\TypeClient;
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
        
        TypeClient::create($requestData);

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
        $typeclient->update($requestData);

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
        TypeClient::destroy($id);

        return redirect('type_client/type-clients')->with('flash_message', 'TypeClient deleted!');
    }
}
