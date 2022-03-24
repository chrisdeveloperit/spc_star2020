<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateMachineSpecRequest;

use App\Models\MachineSpec;
use DB;

class MachineSpecsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $makes = DB::table('machine_specs AS specs')
            ->select('mach_make')
            ->groupBy('mach_make')
            ->orderBy('mach_make')->get();
        
        return view('machine_specs.index', compact('makes'))
            ->with('specs', MachineSpec::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $makes = DB::table('machine_specs AS specs')
            ->select('mach_make')
            ->groupBy('mach_make')
            ->orderBy('mach_make')->get();
        
        return view('machine_specs.create')
        ->with(compact('makes'));

       // ->with('specs', MachineSpec::orderBy('mach_make')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMachineSpecRequest $request)
    { MachineSpec::create([
			'mach_make' => $request->addMakeSel,
			'model' => $request->model,
			'features' => $request->features,
			'min_speed' => $request->min_speed,
			'max_speed' => $request->max_speed,
			'machine_image' => $request->machine_image,
			'intro' => $request->intro,
			'life' => $request->life,
			'is_color' => $request->is_color,
			'created_date' => NOW(),
			'created_by' => 1271,
			'modified_date' => NOW(),
			'modified_by' => 1271
		]);
		session()->flash('success', 'New meter record successfully created');
		
		return redirect(route('machine_specs.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($make_name)
    {
        $makes = DB::table('machine_specs AS specs')
            ->select('mach_make')
            ->groupBy('mach_make')
            ->orderBy('mach_make')->get();
            
        //$makes = MachineSpec::select('mach_make')->groupBy('mach_make')->get()->toArray() ;
            
        /*$mods = DB::table('machine_specs')
            ->select('make', 'model')
            //->where('make', '=', DB::raw($mach_make))
            ->groupBy('make')
            ->groupBy('model')
            ->orderBy('model')->get();*/
            
        return view('machine_specs.index', compact(['makes', 'make_name']))
            ->with('specs', MachineSpec::orderBy('mach_make')->get()
            ->where('mach_make', '=', DB::raw($make_name)));
        
        
        
        //return view('machine_specs.index', compact(['makes', 'mods']))
           // ->with('specs', MachineSpec::orderBy('spec_id')->get());
            //->where('make', '=', DB::raw($mach_make))->get());
            
            
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
        MachineSpec::destroy($id);
		
		session()->flash('success', 'Machine Specification record successfully deleted');		
		
		return redirect(route('machine_specs.index'));
    }
}
