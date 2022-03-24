<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Floorplan;
use App\Models\Building;
use DB;

class FloorplansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('floorplans.index')->with('floorplans', Floorplan::all())
		->with('buildings', Building::orderBy('bldg_name')->get());
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
        $floorplans = DB::table('floorplans AS fp')
			->join('buildings', 'fp.buildings_id', '=', 'buildings.bldg_id')
			->select('fp.fp_id', 'fp.buildings_id', 'fp.floor_number',
				'fp.floorplan_image', 'fp.modified_by', 'fp.modified_date', 'fp.deleted_at')
			->where('fp.deleted_at', NULL)
			->where('fp.buildings_id', '=', DB::raw($bldg_id))->get();
		
		return view('floorplans.index', compact('floorplans', 'bldg_id'))->with('buildings', Building::orderBy('bldg_name')->get());
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
        Floorplan::destroy($id);
		
		session()->flash('success', 'Floorplan record successfully deleted');
		
		return redirect(route('floorplans.index'));
		
		//return view('floorplans.index')->with('floorplans', Floorplan::all())->with('buildings', Building::orderBy('bldg_name')->get());
		
	
		
		
    }
}
