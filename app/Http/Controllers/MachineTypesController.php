<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MachineType;

use App\Http\Requests\CreateMachineTypeRequest;
//use Validator;

use DB;

class MachineTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('machine_types.index')->with('machine_types', MachineType::all());
		//return view('machine_types.index')->with('machine_types', MachineType::orderBy('type_name', 'ASC')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('machine_types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMachineTypeRequest $request)
    {
        MachineType::create([			
			'type_name' => $request->type_name,
			'machine_type' => $request->machine_type,
			'icon_type' => $request->icon_type,
			'is_color' => $request->is_color,
			'covered' => $request->covered,
			'created_date' => NOW(),
			'created_by' => 1271,
			'modified_date' => NOW(),
			'modified_by' => 1271
		]);
		session()->flash('success', 'New machine type successfully created');
		
		return redirect(route('machine_types.index'));
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
    public function edit(MachineType $machineType)
    {
		$data = DB::table('machine_types')
				->select('machine_type')
				->groupBy('machine_type')
				->orderBy('machine_type')				
				->get();
				
		$tNames = DB::table('machine_types')
				->select('id', 'type_name')				
				->orderBy('type_name')				
				->get();
				
		$icons = DB::table('machine_types')
				->select('icon_type')
				->groupBy('icon_type')
				->orderBy('icon_type')				
				->get();
				
		$color = DB::table('machine_types')
				->select('is_color')
				->groupBy('is_color')
				->orderBy('is_color')				
				->get(); 
				
		return view('machine_types.create', compact('data', 'tNames', 'icons', 'color'))
				->with('machine_types', $machineType);
				//->orderBy('type_name');		
        //return view('machine_types.create')->with('machine_types', $machineType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateMachineTypeRequest $request, MachineType $machineType)
    {
        $machineType->update([
			'type_name' => $request->get('type_name'),
			'machine_type' => $request->get('machine_type'),
			'icon_type' => $request->get('icon_type'),			
			'is_color' => $request->get('is_color'),
			'covered' => $request->get('covered'),						
			/*'created_date' => NOW(),
			'created_by' => 1271,*/
			'modified_date' => NOW(),
			'modified_by' => 1271
		]);
		
		$machineType->save();
		
		session()->flash('success', 'Machine Type was successfully updated');
		
		return redirect(route('machine_types.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MachineType::destroy($id);
		
		session()->flash('success', 'Machine type successfully deleted');		
		
		return redirect(route('machine_types.index'));
    }
}
