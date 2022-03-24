<?php

namespace App\Http\Controllers;
use Session;

use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\Building;
use App\Models\Floorplan;
use App\Models\FloorplanMachines;
use App\Models\SchoolYear;
use DB;

class Device_SummariesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$year = 20;    
    	$org_id = 15;
    	$varName = 'year';
    	session([$varName => $year]); 
       
    
    
    	//Session::set('variableName', 455);
        return view('device_summaries.testPage');
       
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
    	
    	//$device_data = ['44', '25', '64'];
    return view('device_summaries.show')
        ->with('orgs', Organization::orderBy('org_name')->get()->where('client_status', 'A'))
        ->with('bldgs', Building::orderBy('bldg_name')->get())
        ->with('years', SchoolYear::orderBy('id', 'desc')->get());
    }

	public function show_toner_data($summary)
    {
     	$org_id = session('org_id');	
     	$year = session('year');
		$color = session('color');
		$yearTab = session('yearTab');
    
    	$serNumDate = DB::table($yearTab . '_machine_status')
                       ->select(DB::raw('max(created_date) as dt, serial_number'))           
                       ->groupBy('serial_number');
                       //->get(); This changes the $serNumDate from a string so an error occurs
    
    
    	$toner_data = DB::table($yearTab . '_machine_status AS ms')
        				/*List only the cols needed instead of selecting all from all joined tables.*/
        				->select(DB::raw('orgs.org_name, fpm.serial_number, fpm.machines_id,
							bldg.bldg_name, fpm.room_name, mach.make, mach.model,
                            fpm.`ip_address`, `fpm`.`mac_address`, fpm.budgeted_black,
                            fpm.budgeted_color, ms.toner, ms.service_needed')) 
        
    				->joinSub($serNumDate, 'serNumDate', function($join){
            												$join->on('ms.serial_number', '=', 'serNumDate.serial_number');
                    										$join->on('ms.created_date', '=', 'serNumDate.dt');})
        
        			->join($yearTab . '_floorplan_machines as fpm', 'fpm.serial_number', '=', 'ms.serial_number')
        			->join('floorplans as fp', 'fp.id', '=', 'fpm.floorplans_id')
        			->join('machines as mach', 'mach.id', '=', 'fpm.machines_id')
        			->join('buildings as bldg', 'bldg.id', '=', 'fp.buildings_id')
     				->join('organizations as orgs', 'orgs.id', '=', 'bldg.organizations_id')
    				
            		->whereIn('ms.serial_number', function($query) use ($org_id, $year){                    
                        									$query->select('serial_number')
                                                                ->from('machine_archive')
                              									->where('org_id', '=', $org_id)
                              									->where('school_year', '=', $year);
                        									})
        			->where('toner', '=', '1')->get();  //->toSql();//  
        
     	
		//dd($toner_data);
	
		/*To get the total of devides w/toner alert, count the records in the array(resultset)*/
		//$toner_alert_count = $toner_data->count();
     	//$service_needed_count = $service_data->count();
		//$contract_devices_count = $contract_devices->count();
    		                        
     	return view('device_summaries.show_toner_data', compact('toner_data', 'org_id', 'year', 'yearTab', 'color', 'toner_data', 'summary'))
			->with('floorplans', Floorplan::all())
			->with('bldgs', Building::orderBy('bldg_name')->get()->where('organizations_id', $org_id))
     		->with('years', SchoolYear::orderBy('id')->get())        
			->with('orgs', Organization::orderBy('org_name')->get()->where('client_status', 'A'));
		
    }

	public function show_service_data($summary)
    {
     	$org_id = session('org_id');	
     	$year = session('year');
		$color = session('color');
		$yearTab = session('yearTab'); 
    
    
    	
    
    
    /*************BEGIN ADDED ON 2/17/2021*******************/
    
    $serNumDate = DB::table($yearTab . '_machine_status')
                       ->select(DB::raw('max(created_date) as dt, serial_number'))           
                       ->groupBy('serial_number');
    
    
    $service_needed = DB::table($yearTab . '_machine_status AS ms')
    				->joinSub($serNumDate, 'serNumDate', function($join){
            												$join->on('ms.serial_number', '=', 'serNumDate.serial_number');
                    										$join->on('ms.created_date', '=', 'serNumDate.dt');})    
    
     /*************END ADDED ON 2/17/2021*******************/
    
    
    
    
    				
     				->join($yearTab . '_floorplan_machines as fpm', 'fpm.serial_number', '=', 'ms.serial_number')
        			->join('floorplans as fp', 'fp.id', '=', 'fpm.floorplans_id')
        			->join('machines as mach', 'mach.id', '=', 'fpm.machines_id')
        			->join('buildings as bldg', 'bldg.id', '=', 'fp.buildings_id')
     				->join('organizations as orgs', 'orgs.id', '=', 'bldg.organizations_id')
            		
        
        			->whereIn('ms.serial_number', function($query) use ($org_id, $year){                    
                        									$query->select('serial_number')
                                                                ->from('machine_archive')
                              									->where('org_id', '=', $org_id)
                              									->where('school_year', '=', $year);
                        									})
        			->where('service_needed', '=', '1')->get();
    
        
    	return view('device_summaries.show_service_needed', compact('org_id', 'year', 'color', 'yearTab', 'service_needed'))
			->with('floorplans', Floorplan::all())
			->with('bldgs', Building::orderBy('bldg_name')->get()->where('organizations_id', $org_id))
     		->with('years', SchoolYear::orderBy('id')->get())        
			->with('orgs', Organization::orderBy('org_name')->get()->where('client_status', 'A'));
    }

	
	public function show_contract_devices($summary)
    {
     	$org_id = session('org_id');	
     	$year = session('year');
		$color = session('color');
		$yearTab = session('yearTab'); 
    
    
    /*HAVING THE EXTRA GROUPBY COLS ADDED > 20 RECORDS TO RESULTSET*/	
    $serNumDate = DB::table($yearTab . '_machine_status')
                       	->select(DB::raw('max(created_date) as dt, serial_number'))           
                       	->groupBy('serial_number');
        				//->groupBy('toner')
        				//->groupBy('service_needed');
    
    	/*Desired query
    	SELECT * FROM Y2019_floorplan_machines fpm
		INNER JOIN floorplans fp ON fp.id = fpm.floorplan_id
        INNER JOIN buildings bldg ON bldg.id = fp.building_id
		WHERE serial_number in (SELECT SerialNumber FROM Machine_Archive
   								WHERE org_id_ma = 15 AND school_year = 19)
		AND model_id != 790 
		AND save_name_id IS NOT NULL;
        
      Actual query
      	select * from `y2019_floorplan_machines` as `fpm`
        inner join `floorplans` as `fp` on `fp`.`id` = `fpm`.`floorplans_id`
        inner join `buildings` as `bldg` on `bldg`.`id` = `fp`.`buildings_id`
        where `fpm`.`serial_number` in (select `serial_number` from `machine_archive`
        								where `org_id` = 15 and `school_year` = 19)
        and `fpm`.`machines_id` != 790 
        nd `fpm`.`fyer_group_id` is not null */	
     
    /*This works. org 1838 is missing 1 rec vs stardoc because the ser num is not in the test y2019_machine_status table */
    $contract_devices = DB::table($yearTab . '_floorplan_machines as fpm')
     					
     		
     ->join($yearTab . '_machine_status as ms', 'ms.serial_number', '=', 'fpm.serial_number')
     ->joinSub($serNumDate, 'serNumDate', function($join){
            												$join->on('ms.serial_number', '=', 'serNumDate.serial_number');
                    										$join->on('ms.created_date', '=', 'serNumDate.dt');})
     
     					->join('floorplans as fp', 'fp.id', '=', 'fpm.floorplans_id')
     					->join('machines as mach', 'mach.id', '=', 'fpm.machines_id')
     					->leftjoin('buildings as bldg', 'bldg.id', '=', 'fp.buildings_id')
     					->join('organizations as orgs', 'orgs.id', '=', 'bldg.organizations_id')     					
    
    					->whereIn('fpm.floorplans_id', function($query)  use ($org_id){ /*Pass org_id to the inner query*/
            											$query->select('fp.id')
                                                    	->from('floorplans as fp')
                                                        ->join('buildings as bldgs', 'bldgs.id', '=', 'fp.buildings_id')
                                                        ->whereIn('fp.buildings_id', function($queryF) use ($org_id){
                                                        							$queryF->select('id')
                                                                                    ->from('buildings')                                                                                  
                                                    								->where('organizations_id', '=', $org_id);                                                                                                                
            																		});
                        								})
        				->where('fpm.machines_id', '!=', 790)
        				->whereNotNull('fpm.fyer_group_id')->get();//->toSql(); //->get()
     
     //dd($contract_devices);
    
    	return view('device_summaries.show_contract_devices', compact('org_id', 'year', 'color', 'yearTab', 'contract_devices'))
			->with('floorplans', Floorplan::all())
			->with('bldgs', Building::orderBy('bldg_name')->get()->where('organizations_id', $org_id))
     		->with('years', SchoolYear::orderBy('id')->get())        
			->with('orgs', Organization::orderBy('org_name')->get()->where('client_status', 'A'));
    /*Actual query
     * select * from `y2019_floorplan_machines` as `fpm`
inner join `y2019_machine_status` as `ms` on `ms`.`serial_number` = `fpm`.`serial_number`
inner join (select max(created_date) as dt, serial_number
            from `y2019_machine_status`
            group by `serial_number`) as `serNumDate` on `ms`.`serial_number` = `serNumDate`.`serial_number`
            and `ms`.`created_date` = `serNumDate`.`dt`
inner join `floorplans` as `fp` on `fp`.`id` = `fpm`.`floorplans_id`
inner join `machines` as `mach` on `mach`.`id` = `fpm`.`machines_id`
left join `buildings` as `bldg` on `bldg`.`id` = `fp`.`buildings_id`
inner join `organizations` as `orgs` on `orgs`.`id` = `bldg`.`organizations_id`
where `fpm`.`floorplans_id` in (select `fp`.`id` from `floorplans` as `fp`
                                inner join `buildings` as `bldgs` on `bldgs`.`id` = `fp`.`buildings_id`
                                where `fp`.`buildings_id` in (select `id` from `buildings`
                                                              where `organizations_id` = 4))
and `fpm`.`machines_id` != 790 and `fpm`.`fyer_group_id` is not null; */
    
    
    
    }


public function show_non_contract_devices($summary)
    {
     	$org_id = session('org_id');	
     	$year = session('year');
		$color = session('color');
		$yearTab = session('yearTab'); 
    
    
    /*HAVING THE EXTRA GROUPBY COLS ADDED > 20 RECORDS TO RESULTSET*/	
    $serNumDate = DB::table($yearTab . '_machine_status')
                       	->select(DB::raw('max(created_date) as dt, serial_number'))           
                       	->groupBy('serial_number');
        				//->groupBy('toner')
        				//->groupBy('service_needed');
    
    	/*Desired query
    	SELECT * FROM Y2019_floorplan_machines fpm
		INNER JOIN floorplans fp ON fp.id = fpm.floorplan_id
        INNER JOIN buildings bldg ON bldg.id = fp.building_id
		WHERE serial_number in (SELECT SerialNumber FROM Machine_Archive
   								WHERE org_id_ma = 15 AND school_year = 19)
		AND model_id != 790 
		AND save_name_id IS NOT NULL;
        
      Actual query
      	select * from `y2019_floorplan_machines` as `fpm`
        inner join `floorplans` as `fp` on `fp`.`id` = `fpm`.`floorplans_id`
        inner join `buildings` as `bldg` on `bldg`.`id` = `fp`.`buildings_id`
        where `fpm`.`serial_number` in (select `serial_number` from `machine_archive`
        								where `org_id` = 15 and `school_year` = 19)
        and `fpm`.`machines_id` != 790 
        nd `fpm`.`fyer_group_id` is not null */	
     
     $non_contract_devices = DB::table($yearTab . '_floorplan_machines as fpm')     					
     		
     ->join($yearTab . '_machine_status as ms', 'ms.serial_number', '=', 'fpm.serial_number')
     ->joinSub($serNumDate, 'serNumDate', function($join){
            												$join->on('ms.serial_number', '=', 'serNumDate.serial_number');
                    										$join->on('ms.created_date', '=', 'serNumDate.dt');})
     
     					->join('floorplans as fp', 'fp.id', '=', 'fpm.floorplans_id')
     					->join('machines as mach', 'mach.id', '=', 'fpm.machines_id')
     					->join('buildings as bldg', 'bldg.id', '=', 'fp.buildings_id')
     					->join('organizations as orgs', 'orgs.id', '=', 'bldg.organizations_id')
     					//->join($yearTab . '_machine_status as ms', 'ms.serial_number', '=', 'serNumDate.serial_number')
     					//->where('ms.created_date', '-', 'serNumDate.dt')
        				->whereIn('fpm.serial_number', function($query) use ($org_id, $year){
            											$query->select('serial_number')
                                                    	->from('machine_archive')
                                                    	->where('org_id', '=', $org_id)
                                                        ->where('school_year', '=',  $year);
            										})
        				->where('fpm.machines_id', '!=', 790)
        				->whereNull('fpm.fyer_group_id')->get();//->toSql();
     
     
    
    	return view('device_summaries.show_non_contract_devices', compact('org_id', 'year', 'color', 'yearTab', 'non_contract_devices'))
			->with('floorplans', Floorplan::all())
			->with('bldgs', Building::orderBy('bldg_name')->get()->where('organizations_id', $org_id))
     		->with('years', SchoolYear::orderBy('id')->get())        
			->with('orgs', Organization::orderBy('org_name')->get()->where('client_status', 'A'));
    }
    
    
	public function show_reporting_devices($summary)
    {
     	$org_id = session('org_id');	
     	$year = session('year');
		$color = session('color');
		$yearTab = session('yearTab'); 
    
    
    
    	$serNumDate = DB::table($yearTab . '_machine_status')
                       	->select(DB::raw('max(created_date) as dt, serial_number'))           
                       	->groupBy('serial_number');
       	
    	$lastMeterRead = DB::table($yearTab . '_meters')
                       ->select(DB::raw('max(created_date) as mtr_dt, serial_number'))           
                       ->groupBy('serial_number');
    
    
    	$reporting_devices = DB::table($yearTab . '_meters as m')// Carbon::now()->subDays(30)
        				->join($yearTab . '_floorplan_machines as fpm', 'fpm.serial_number', '=', 'm.serial_number')
        				->join('machines as mach', 'mach.id', '=', 'fpm.machines_id')
        				->join($yearTab . '_machine_status as ms', 'ms.serial_number', '=', 'fpm.serial_number')
        				->joinSub($serNumDate, 'serNumDate', function($join){
            												$join->on('ms.serial_number', '=', 'serNumDate.serial_number');
                    										$join->on('ms.created_date', '=', 'serNumDate.dt');})
        
        				->joinSub($lastMeterRead, 'lastMeterRead', function($join){
            												$join->on('m.serial_number', '=', 'lastMeterRead.serial_number');
                    										$join->on('m.created_date', '=', 'lastMeterRead.mtr_dt');})
       					->join('floorplans as fp', 'fp.id', '=', 'fpm.floorplans_id')
        				->join('buildings as bldgs', 'bldgs.id', '=', 'fp.buildings_id')
        				->join('organizations as orgs', 'orgs.id', '=', 'bldgs.organizations_id')
        				->where('bldgs.organizations_id', '=', $org_id)
        				->where('fpm.machines_id', '!=', 790)
        				->whereNotNull('fpm.fyer_group_id')
        				->where('m.created_date', '>=', '2019-06-15 00:00:00')->get();
    
          	    
    
    	return view('device_summaries.show_reporting_devices', compact('org_id', 'year', 'color', 'yearTab', 'reporting_devices'))
			->with('floorplans', Floorplan::all())
			->with('bldgs', Building::orderBy('bldg_name')->get()->where('organizations_id', $org_id))
     		->with('years', SchoolYear::orderBy('id')->get())        
			->with('orgs', Organization::orderBy('org_name')->get()->where('client_status', 'A'));
    }



	public function show_not_reporting_devices($summary)
    {
     	$org_id = session('org_id');	
     	$year = session('year');
		$color = session('color');
		$yearTab = session('yearTab'); 
    
    
    
    	$serNumDate = DB::table($yearTab . '_machine_status')
                       	->select(DB::raw('max(created_date) as dt, serial_number'))           
                       	->groupBy('serial_number');
       	
    	$lastMeterRead = DB::table($yearTab . '_meters')
                       ->select(DB::raw('max(created_date) as mtr_dt, serial_number'))           
                       ->groupBy('serial_number');
    
    
    	$not_reporting = DB::table($yearTab . '_meters as m')// Carbon::now()->subDays(30)
        				->join($yearTab . '_floorplan_machines as fpm', 'fpm.serial_number', '=', 'm.serial_number')
        				->join('machines as mach', 'mach.id', '=', 'fpm.machines_id')
        				->join($yearTab . '_machine_status as ms', 'ms.serial_number', '=', 'fpm.serial_number')
        				->joinSub($serNumDate, 'serNumDate', function($join){
            												$join->on('ms.serial_number', '=', 'serNumDate.serial_number');
                    										$join->on('ms.created_date', '=', 'serNumDate.dt');})
        
        				->joinSub($lastMeterRead, 'lastMeterRead', function($join){
            												$join->on('m.serial_number', '=', 'lastMeterRead.serial_number');
                    										$join->on('m.created_date', '=', 'lastMeterRead.mtr_dt');})
       					->join('floorplans as fp', 'fp.id', '=', 'fpm.floorplans_id')
        				->join('buildings as bldgs', 'bldgs.id', '=', 'fp.buildings_id')
        				->join('organizations as orgs', 'orgs.id', '=', 'bldgs.organizations_id')
        				->where('bldgs.organizations_id', '=', $org_id)
        				->where('fpm.machines_id', '!=', 790)
        				->whereNotNull('fpm.fyer_group_id')
        				->where('m.created_date', '<', '2019-06-15 00:00:00')->get();
    
          	    
    
    	return view('device_summaries.show_not_reporting_devices', compact('org_id', 'year', 'color', 'yearTab', 'not_reporting'))
			->with('floorplans', Floorplan::all())
			->with('bldgs', Building::orderBy('bldg_name')->get()->where('organizations_id', $org_id))
     		->with('years', SchoolYear::orderBy('id')->get())        
			->with('orgs', Organization::orderBy('org_name')->get()->where('client_status', 'A'));
    }
    


	public function setSelectedSessionVariable($goToUrl, $varName, $thisVar){
		session(['varName' => 'year']);
    
    	//page_direct('gauges.show_by_org', 'thisVar');
		//print("<script>alert('hello');</script>");
	//print("<script>page_direct('" . $goToUrl. "', '" . $thisVar . "')</script");

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
