<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FloorplanMachine;
use App\Models\Floorplan;
use DB;

class FloorplanMachinesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('floorplan_machines.index')
        ->with('machs', FloorplanMachine::all())  //->orderBy('present_serial_number')
        //->with('plans', Floorplan::all());
        ->with('plans', Floorplan::orderBy('buildings_id')->orderBy('floor_number')->get());
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
    public function show($plan_id)
    {
         $machs = DB::table('floorplan_machines AS fpm')
			->join('floorplans', 'fpm.present_floorplans_id', '=', 'floorplans.fp_id')
			->select('fpm.fpm_id', 'fpm.present_floorplans_id', 'fpm.departments_id',
				'fpm.proposed_x_position', 'fpm.proposed_y_position')
			->where('fpm.present_floorplans_id', '=', DB::raw($plan_id))->get();
		
		return view('floorplan_machines.index', compact(['machs', 'plan_id']))->with('plans', Floorplan::orderBy('buildings_id')->orderBy('floor_number')->get());
		
		//return view('floorplan_machines.index', compact('machs'))->with('plans', Floorplan::orderBy('buildings_id')->orderBy('floor_number')->get());
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
    public function destroy($fpm_id)
    {
        FloorplanMachine::destroy($fpm_id);
        session()->flash('success', 'The Floorplan Machine record was successfully deleted.');
        
        return redirect(route('floorplan_machines.index'));
        
        //return redirect()->route('floorplan_machines.show', ['$plan_id' => 190]);
    }
}
