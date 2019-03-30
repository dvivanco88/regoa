<?php

namespace App\Http\Controllers\Stat;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Stat;
use App\LogWorkFlow;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

class StatsController extends Controller
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
            $stats = Stat::where('name', 'LIKE', "%$keyword%")
            ->orWhere('description', 'LIKE', "%$keyword%")
            ->orWhere('is_active', 'LIKE', "%$keyword%")
            ->latest()->paginate($perPage);
        } else {
            $stats = Stat::latest()->paginate($perPage);
        }

        return view('stat.stats.index', compact('stats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('stat.stats.create');
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
        
        $estado = Stat::create($requestData);

        $lwf = new LogWorkFlow;
        $lwf->controller_name = Route::current()->action['controller'];
        $lwf->action = 'CREAR';
        $lwf->page = Route::current()->uri;
        $lwf->register_id = $estado->id;
        $lwf->user_id = auth()->user()->id;
        $lwf->info1 = $estado->toJson(JSON_PRETTY_PRINT);
        $lwf->save();

        return redirect('stat/stats')->with('flash_message', 'Stat added!');
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
        $stat = Stat::findOrFail($id);

        return view('stat.stats.show', compact('stat'));
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
        $stat = Stat::findOrFail($id);

        return view('stat.stats.edit', compact('stat'));
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
        
        $stat = Stat::findOrFail($id);
        $record_temp = Stat::find($id);
        $stat->update($requestData);


        $lwf = new LogWorkFlow;
        $lwf->controller_name = Route::current()->action['controller'];
        $lwf->action = 'ACTUALIZAR';
        $lwf->page = Route::current()->uri;
        $lwf->register_id = $stat->id;
        $lwf->user_id = auth()->user()->id;
        $lwf->info1 = $stat->toJson(JSON_PRETTY_PRINT);
        $lwf->info2 = $record_temp->toJson(JSON_PRETTY_PRINT);
        $lwf->save();

        return redirect('stat/stats')->with('flash_message', 'Stat updated!');
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
        $record_temp = Stat::find($id);
        Stat::destroy($id);

        
        $lwf = new LogWorkFlow;
        $lwf->controller_name = Route::current()->action['controller'];
        $lwf->action = 'ELIMINAR';
        $lwf->page = Route::current()->uri;
        $lwf->register_id = $record_temp->id;
        $lwf->user_id = auth()->user()->id;
        $lwf->info1 = $record_temp->toJson(JSON_PRETTY_PRINT);        
        $lwf->save();

        return redirect('stat/stats')->with('flash_message', 'Stat deleted!');
    }
}
