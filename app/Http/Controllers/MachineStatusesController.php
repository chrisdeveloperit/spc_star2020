<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateMachineStatusRequest;
use App\Models\MachineStatus;
use App\Models\CurrentDevice;

use DB;

class MachineStatusesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('machine_statuses.index')->with('mach_stat', MachineStatus::orderBy('status_id')
		->get());
		
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('machine_statuses.create')->with('current_devices', CurrentDevice::orderBy('serial_number')
		->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        MachineStatus::create([			
			'serial_number' => $request->get('serial_number'),
			'toner' => $request->toner,
			'service_needed' => $request->service_needed,						
			'created_date' => NOW(),
			'created_by' => 1271,
			'modified_date' => NOW(),
			'modified_by' => 1271
		]);
		session()->flash('success', 'New machine status record successfully created');
		
		return redirect(route('machine_statuses.index'));
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
    public function edit(MachineStatus $machineStatus)
    {
        return view('machine_statuses.create')
				->with('machine_statuses', $machineStatus);				
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateMachineStatusRequest $request, MachineStatus $machineStatus)
    {
        $machineStatus->update([
			'toner' => $request->get('toner'),
			'service_needed' => $request->get('service_needed'),			
			'modified_date' => NOW(),
			'modified_by' => 1271
		]);
		
		$machineStatus->save();
		
		session()->flash('success', 'Machine Status was successfully updated');
		
		return redirect(route('machine_statuses.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MachineStatus::destroy($id);
		
		session()->flash('success', 'Machine status successfully deleted');		
		
		return redirect(route('machine_statuses.index'));
    }
}
