<?php

/*Controllers/MetersController*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\CreateMeterRequest;
use App\Models\Meter;
use App\Models\SchoolYear;
use DB;

class MetersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('meters.index')->with('years', SchoolYear::all())
			->with('meters', Meter::get()
			->whereNotNull('serial_number')
			->where('serial_number', '!=', ''));
		
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('meters/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMeterRequest $request)
    {
        Meter::create([
			//'serial_number' => $request->name,
			'serial_number' => $request->serial_number,
			'black_meter' => $request->black_meter,
			'color_meter' => $request->color_meter,
			'created_date' => NOW(),
			'created_by' => 1271,
			'modified_date' => NOW(),
			'modified_by' => 1271
		]);
		session()->flash('success', 'New meter record successfully created');
		
		return redirect(route('meters.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function showAllMeters($year) 
    { 
		return view('meters.show')->with('meters', Meter::get()->whereYear('created_date', '2020'));
    }*/
	
	public function show($year)
    {
        //return view('meters.index')->with('meters', Meter::all()); //get()->whereYear('created_date', '2018'));
		//return view('meters.index')->with('meters', Meter::orderBy('id')->get()->where('created_date', '%' . $year . '%'));
		
		$meters = DB::select("select * from meters where year(created_date) = " . 20 . DB::raw($year));
								
		
		return view('meters.index', compact('meters', 'year'))->with('years', SchoolYear::orderBy('id')->get());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Meter $meter)
    {
        //return view('meters.edit', $id);
		return view('meters.create')->with('meter', $meter);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateMeterRequest $request, Meter $meter)
    {
        $meter->update([
			'machines_id' => $request->machines_id,
			'black_meter' => $request->black_meter,
			'color_meter' => $request->color_meter,
			'modified_date' => NOW(),
			'modified_by' => 1271
		]);
		
		$meter->save();
		
		session()->flash('success', 'Meter record was successfully updated');
		
		return redirect(route('meters.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Meter::destroy($id);
		
		session()->flash('success', 'Meter record successfully deleted');		
		
		return redirect(route('meters.index'));
    }
}
