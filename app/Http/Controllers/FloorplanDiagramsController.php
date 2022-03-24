<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Floorplan;
use App\Models\Building;
use App\Models\Organization;
use DB;

class FloorplanDiagramsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$data = DB::table('floorplans AS fp')
			->join('buildings AS bldg', 'bldg.id', '=', 'fp.buildings_id')
			->select('fp.floorplan_image', 'fp.floor_number', 'fp.id')
			->orderBy('fp.floor_number')->get()
			->first();
			
		
        return view('floorplan_diagrams.index', compact('data'))
			->with('floorplans', Floorplan::all())
			->with('buildings', Building::orderBy('bldg_name')->get())
			->with('orgs', Organization::orderBy('org_name')->get()->where('client_status', 'A'));
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
    public function show($bldg_id)
    {
        $data = DB::table('floorplans AS fp')
			->join('buildings AS bldg', 'bldg.id', '=', 'fp.buildings_id')
			->select('fp.floorplan_image', 'fp.floor_number')			
			->where(array('fp.buildings_id' => $bldg_id,
					'fp.floor_number' => '1'))			
			->orderBy('fp.floor_number')
			->first();
			
		$floors = DB::table('floorplans')
			->select('floor_number')
			->where('buildings_id', '=', $bldg_id)
			->orderBy('floor_number')->get();
			
		/*subquery*/
		$oid = DB::table('organizations')
					->join('buildings', 'buildings.organizations_id', '=', 'organizations.id')
					->select('organizations.id AS org_id')
					->where('buildings.id', '=', $bldg_id);
			
		$bldgs = DB::table('buildings AS bldg')
			->joinSub($oid, 'org', function($join){
				$join->on('org.org_id', '=', 'bldg.organizations_id');
			})
			->select('bldg.id AS bldg_id', 'bldg.bldg_name', 'bldg.organizations_id')			
			->orderBy('bldg.bldg_name')->get();
			
		
        return view('floorplan_diagrams.index', compact('data', 'bldgs', 'bldg_id', 'floors'))
			->with('floorplans', Floorplan::all())
			->with('buildings', Building::orderBy('bldg_name')->get())
			->with('orgs', Organization::orderBy('org_name')->get()->where('client_status', 'A'));
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
        //
    }
}
