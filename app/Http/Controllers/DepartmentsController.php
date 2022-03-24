<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Department;
use App\Models\Organization;

use DB;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('departments.index')->with('orgs', Organization::orderBy('org_name')->get()->where('client_status', 'A'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        	$dept_data = DB::table('departments')
				->join('organizations', function ($join) use ($id){
								$join->on('departments.organizations_id', '=', 'organizations.org_id')
								->select('departments.*', 'organizations.org_name')
								->where('departments.deleted_at', NULL)
								->where('organizations_id', '=', DB::raw($id));
				})
			->orderBy('departments.dept_name')->get();
			
			return view('departments.index', compact('dept_data', 'id'))->with('orgs', Organization::orderBy('org_name')->get()->where('client_status', 'A'));
			
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Department::destroy($id);
		
		session()->flash('success', 'Department record successfully deleted');
		return redirect(route('departments.index'));
		
    }
}
