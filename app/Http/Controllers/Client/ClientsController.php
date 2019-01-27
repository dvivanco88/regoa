<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Client;
use Illuminate\Http\Request;

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
            $clients = Client::where('name', 'LIKE', "%$keyword%")
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
            $clients = Client::latest()->paginate($perPage);
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
        return view('client.clients.create');
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
			'contact' => 'required',
			'telephone1' => 'required',
			'type_business' => 'required',
			'contact_position' => 'required'
		]);
        $requestData = $request->all();
        
        Client::create($requestData);

        return redirect('client/clients')->with('flash_message', 'Client added!');
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
        $client = Client::findOrFail($id);

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
        $client = Client::findOrFail($id);

        return view('client.clients.edit', compact('client'));
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
			'contact' => 'required',
			'telephone1' => 'required',
			'type_business' => 'required',
			'contact_position' => 'required'
		]);
        $requestData = $request->all();
        
        $client = Client::findOrFail($id);
        $client->update($requestData);

        return redirect('client/clients')->with('flash_message', 'Client updated!');
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
        Client::destroy($id);

        return redirect('client/clients')->with('flash_message', 'Client deleted!');
    }
}
