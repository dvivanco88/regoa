<?php

namespace App\Http\Controllers\Stat;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Stat;
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
        
        Stat::create($requestData);

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
        $stat->update($requestData);

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
        Stat::destroy($id);

        return redirect('stat/stats')->with('flash_message', 'Stat deleted!');
    }
}
