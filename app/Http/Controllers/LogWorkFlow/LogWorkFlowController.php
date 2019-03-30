<?php

namespace App\Http\Controllers\LogWorkFlow;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\LogWorkFlow;
use Illuminate\Http\Request;

class LogWorkFlowController extends Controller
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
            $logworkflow = LogWorkFlow::select('log_work_flows.*', 'users.name')
            ->with('user')
            ->join('users', 'log_work_flows.user_id', '=', 'users.id')
            ->where('action', 'LIKE', "%$keyword%")
                ->orWhere('log_work_flows.page', 'LIKE', "%$keyword%")
                ->orWhere('log_work_flows.register_id', 'LIKE', "%$keyword%")
                ->orWhere('log_work_flows.controller_name', 'LIKE', "%$keyword%")
                ->orWhere('users.name', 'LIKE', "%$keyword%")                
                ->latest()->paginate($perPage);
        } else {
            $logworkflow = LogWorkFlow::select('log_work_flows.*', 'users.name')
            ->with('user')
            ->join('users', 'log_work_flows.user_id', '=', 'users.id')
            ->latest()->paginate($perPage);
        }

        return view('log_work_flow.log-work-flow.index', compact('logworkflow'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('log_work_flow.log-work-flow.create');
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
			'action' => 'required',
			'page' => 'required',
			'register_id' => 'required'
		]);
        $requestData = $request->all();
        
        LogWorkFlow::create($requestData);

        return redirect('log_work_flow/log-work-flow')->with('flash_message', 'LogWorkFlow added!');
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
        $logworkflow = LogWorkFlow::select('log_work_flows.*', 'users.name')
            ->with('user')
            ->join('users', 'log_work_flows.user_id', '=', 'users.id')
            ->find($id);

        return view('log_work_flow.log-work-flow.show', compact('logworkflow'));
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
        $logworkflow = LogWorkFlow::findOrFail($id);

        return view('log_work_flow.log-work-flow.edit', compact('logworkflow'));
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
			'action' => 'required',
			'page' => 'required',
			'register_id' => 'required'
		]);
        $requestData = $request->all();
        
        $logworkflow = LogWorkFlow::findOrFail($id);
        $logworkflow->update($requestData);

        return redirect('log_work_flow/log-work-flow')->with('flash_message', 'LogWorkFlow updated!');
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
        LogWorkFlow::destroy($id);

        return redirect('log_work_flow/log-work-flow')->with('flash_message', 'LogWorkFlow deleted!');
    }
}
