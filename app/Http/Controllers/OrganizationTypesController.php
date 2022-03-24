<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrganizationType;

class OrganizationTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return view('show_lookups')->with('orgTypes', OrganizationType::orderBy('org_type_name')->get());
		return view('organization_types.index')->with('orgTypes', OrganizationType::orderBy('org_type_name')->get());
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
        $this->validate($request,
			['org_type_name'=>'required|unique:organization_types' /*Check to make sure the org_type_name does not exist already in organization_types*/
			]);
			
		OrganizationType::create([
			'org_type_name'=>$request->org_type_name,
			'created_date'=>NOW(),
			'created_by'=>1271,
			'modified_date'=>NOW(),
			'modified_by'=>1271			
		]);
		
		session()->flash('success', 'New Org Type successfully created');
		
		return redirect(route('org_types.index'));
		
		
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($type_id)
    {
		$type_name = OrganizationType::find($type_id);
		return view ('organization_types.update')->with('typeRec', $type_name)->with('orgTypes', OrganizationType::orderBy('org_type_name')->get());
        //return view('organizations.edit_org_type', compact('type_id', 'type_name'))->with('orgTypes', OrganizationType::orderBy('org_type_name')->get());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrganizationType $org_type)
    {
        /*validate the data coming in*/
		$this->validate($request,
			['org_type_name'=>'required|unique:organization_types'
			]);
			
			
		$org_type->update([
			'org_type_name'=>$request->org_type_name
		]);
		
		$org_type->save();
		
		session()->flash('success', 'Org type updated successfully');
		
		return redirect(route('org_types.index'));
			
		
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($org_type)
    {
        OrganizationType::destroy($org_type);
		
		session()->flash('success', 'Org Type successfully deleted');
		
		return redirect(route('org_types.index'));
    }
}
