<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\Building;
use App\Models\Floorplan;
use App\Models\FloorplanMachines;
use App\Models\SchoolYear;
use DB;
use Carbon\Carbon;

class GaugesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    	
        return view('gauges.index')
			->with('orgs', Organization::orderBy('org_name')->get()->where('client_status', 'A'));
    }

    
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified data for the selected org with color defaulting to both
     * and year, and timeline date defaulting to current year values.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($org_id)
    {
    	/*Set the default values for these session variables*/    		
    	$year = '19';
    	$color = 'both';
    	$yearTab = 'y20' . $year;
    	session(['org_id' => $org_id]);
    	session(['year' => $year]);
    	session(['color' => $color]);
    	session(['yearTab' => $yearTab]);
    
    	/*THIS IS JUST A FAKE NUMBER TO PUT SOME DATA INTO THE GAUGES*/
		$fp_data = 72;
    	
		
    	/*Used as a subquery in several queries*/	
    	$serNumDate = DB::table($yearTab . '_machine_status')
                       ->select(DB::raw('max(created_date) as dt, serial_number'))           
                       ->groupBy('serial_number'); //->get(); This changes the $serNumDate from a string so an error occurs
                           
    	/*********************************** BEGIN TONER_DATA ************************************/    			
		$toner_data = DB::table($yearTab . '_machine_status AS ms')
    				->joinSub($serNumDate, 'serNumDate', function($join){
            												$join->on('ms.serial_number', '=', 'serNumDate.serial_number');
                    										$join->on('ms.created_date', '=', 'serNumDate.dt');})
    				
            		->whereIn('ms.serial_number', function($query) use ($org_id, $year){                    
                        									$query->select('serial_number')
                                                                ->from('machine_archive')
                              									->where('org_id', '=', $org_id)
                              									->where('school_year', '=', $year);
                        									})
        			->where('toner', '=', '1')->get();
    	/*********************************** END TONER_DATA ************************************/
	
		
    	/*********************************** BEGIN SERVICE_DATA ************************************/
    	/*This is the same query as for toner_data except that the last where clause is specific to service_needed instead of toner.*/
		$service_data = DB::table($yearTab . '_machine_status AS ms')
    				->joinSub($serNumDate, 'serNumDate', function($join){
            												$join->on('ms.serial_number', '=', 'serNumDate.serial_number');
                    										$join->on('ms.created_date', '=', 'serNumDate.dt');})
    				
            		->whereIn('ms.serial_number', function($query) use ($org_id, $year){                    
                        									$query->select('serial_number')
                                                                ->from('machine_archive')
                              									->where('org_id', '=', $org_id)
                              									->where('school_year', '=', $year);
                        									})
        			->where('service_needed', '=', '1')->get();
		/*********************************** END SERVICE_DATA ************************************/
        	   	
    
    	/*********************************** BEGIN CONTRACT_DEVICES ************************************/
    	$contract_devices = DB::table($yearTab . '_floorplan_machines as fpm')
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
        				->whereNotNull('fpm.fyer_group_id')->get();
    	/*********************************** END CONTRACT_DEVICES ************************************/
    
    
    
    	/*********************************** BEGIN NON_CONTRACT_DEVICES ************************************/
    	$non_contract_devices = DB::table($yearTab . '_floorplan_machines as fpm')
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
        				->whereNull('fpm.fyer_group_id')->get();
    	/*********************************** END NON_CONTRACT_DEVICES ************************************/
    
    	
    
    	/*********************************** BEGIN LAST_SYNC_DATE ************************************/
        $last_sync_date = DB::table('meters as mtr')
                       	->select(DB::raw('max(created_date) as dt'))        				
        				->whereIn('mtr.serial_number', function($query) use ($yearTab, $org_id){
            											$query->select('fm.serial_number')
                                                    	->from($yearTab . '_floorplan_machines as fm')
                                                        ->join('floorplans as fp', 'fp.id', '=', 'fm.floorplans_id')
                                                        ->join('buildings as bldg', 'bldg.id', '=', 'fp.buildings_id')
                                                    	->where('bldg.organizations_id', '=', $org_id)
                                                        ->whereNotNull('fm.serial_number')
                                                        ->where('fm.serial_number', '!=', '');
            										})->first('dt');
    	/*********************************** END LAST_SYNC_DATE ************************************/
    
    
    
    	
    	/*********************************** BEGIN VOLUME_TOTALS ************************************/
    	$volume_totals = DB::table('machine_archive')
        				->select(DB::raw('SUM(projected_volume_black) as budget_blk, SUM(projected_volume_color) as budget_col,
                                        SUM(meter_end_read_black - meter_begin_read_black) as consumed_blk,
                                        SUM(meter_end_read_color - meter_begin_read_color) as consumed_col'))
        				->whereIn('serial_number', function($query) use($year, $yearTab, $org_id){
                        									$query->select('fpm.serial_number')
                                                            ->from($yearTab . '_floorplan_machines as fpm')
                                                            ->join('floorplans as fp', 'fp.id', '=', 'fpm.floorplans_id')
                                                            ->join('buildings as bldgs', 'bldgs.id', '=', 'fp.buildings_id')
                                                            ->where('bldgs.organizations_id', '=', $org_id);
                        							})
        				->where('school_year', '=', $year)->first();
    
    	$budget_black = number_format($volume_totals->budget_blk,0 ,0, ',');
    	$budget_color = number_format($volume_totals->budget_col,0 ,0, ',');
    	$cons_black = number_format($volume_totals->consumed_blk,0 ,0, ',');
    	$cons_color = number_format($volume_totals->consumed_col,0 ,0, ',');
    	/*********************************** END VOLUME_TOTALS ************************************/
    	
   	
    
    	
    	
    	/*Used as a subquery in devices_reporting and not_reporting queries*/
    	$lastMeterRead = DB::table($yearTab . '_meters')
                       ->select(DB::raw('max(created_date) as dt, serial_number'))           
                       ->groupBy('serial_number');
    
    
    	
    	/*********************************** BEGIN NOT_REPORTING ************************************/
    	$not_reporting = DB::table($yearTab . '_meters as m')// Carbon::now()->subDays(30)
        				->join($yearTab . '_floorplan_machines as fpm', 'fpm.serial_number', '=', 'm.serial_number')
        				->joinSub($lastMeterRead, 'lastMeterRead', function($join){
            												$join->on('m.serial_number', '=', 'lastMeterRead.serial_number');
                    										$join->on('m.created_date', '=', 'lastMeterRead.dt');})
       					->join('floorplans as fp', 'fp.id', '=', 'fpm.floorplans_id')
        				->join('buildings as bldgs', 'bldgs.id', '=', 'fp.buildings_id')
        				->where('bldgs.organizations_id', '=', $org_id)
        				->where('fpm.machines_id', '!=', 790)
        				->whereNotNull('fpm.fyer_group_id')
        				->where('m.created_date', '<', '2019-06-15 00:00:00')->get();
    	/*********************************** END NOT_REPORTING ************************************/
    
    
    
    	
    	/*********************************** BEGIN DEVICES_REPORTING ************************************/
    	$devices_reporting = DB::table($yearTab . '_meters as m')// Carbon::now()->subDays(30)
        				->join($yearTab . '_floorplan_machines as fpm', 'fpm.serial_number', '=', 'm.serial_number')
        				->joinSub($lastMeterRead, 'lastMeterRead', function($join){
            												$join->on('m.serial_number', '=', 'lastMeterRead.serial_number');
                    										$join->on('m.created_date', '=', 'lastMeterRead.dt');})
       					->join('floorplans as fp', 'fp.id', '=', 'fpm.floorplans_id')
        				->join('buildings as bldgs', 'bldgs.id', '=', 'fp.buildings_id')
        				->where('bldgs.organizations_id', '=', $org_id)
        				->where('fpm.machines_id', '!=', 790)
        				->whereNotNull('fpm.fyer_group_id')
        				->where('m.created_date', '>=', '2019-06-15 00:00:00')->get();
    
    	/*********************************** END DEVICES_REPORTING ************************************/
    
        	
    	     
    	/*To get the total of devices w/toner alert, count the records in the array(resultset)*/
		$toner_alert_count = $toner_data->count();
		$service_needed_count = $service_data->count();
    	$contract_devices_count = $contract_devices->count();
    	$non_contract_devices_count = $non_contract_devices->count();
    	$devices_reporting_count = $devices_reporting->count();
    	$not_reporting_count = $not_reporting->count();
    
		
		return view('gauges.show', compact('fp_data', 'org_id', 'year', 'yearTab', 'color', 'toner_alert_count', 'service_needed_count',
                                           'contract_devices_count', 'non_contract_devices_count', 'devices_reporting_count',
                                           'not_reporting_count', 'last_sync_date', 'budget_black', 'budget_color', 'cons_black', 'cons_color'))
			->with('floorplans', Floorplan::all())
			->with('bldgs', Building::orderBy('bldg_name')->get()->where('organizations_id', $org_id))
			->with('years', SchoolYear::orderBy('id')->get())        
        	->with('orgs', Organization::orderBy('org_name')->get()->where('client_status', 'A'));
    }

	
	
	/*Display the specified data for the selected org with color, year, and timeline date displaying the selected
	 * values or defaults when at least 1 selection of these 3 was made.*/	
public function show_by_org($org_id)
    {		
    	/*THIS IS JUST A FAKE NUMBER TO PUT SOME DATA INTO THE GAUGES*/
		$fp_data = 72;
        $year = session('year');
		$color = session('color');
		$yearTab = session('yearTab');
    
    	/*Used as a subquery in several queries*/	
    	$serNumDate = DB::table($yearTab . '_machine_status')
                       ->select(DB::raw('max(created_date) as dt, serial_number'))           
                       ->groupBy('serial_number'); //->get(); This changes the $serNumDate from a string so an error occurs
                           
    	/*********************************** BEGIN TONER_DATA ************************************/    			
		$toner_data = DB::table($yearTab . '_machine_status AS ms')
    				->joinSub($serNumDate, 'serNumDate', function($join){
            												$join->on('ms.serial_number', '=', 'serNumDate.serial_number');
                    										$join->on('ms.created_date', '=', 'serNumDate.dt');})
    				
            		->whereIn('ms.serial_number', function($query) use ($org_id, $year){                    
                        									$query->select('serial_number')
                                                                ->from('machine_archive')
                              									->where('org_id', '=', $org_id)
                              									->where('school_year', '=', $year);
                        									})
        			->where('toner', '=', '1')->get();
    	/*********************************** END TONER_DATA ************************************/
	
		
    	/*********************************** BEGIN SERVICE_DATA ************************************/
    	/*This is the same query as for toner_data except that the last where clause is specific to service_needed instead of toner.*/
		$service_data = DB::table($yearTab . '_machine_status AS ms')
    				->joinSub($serNumDate, 'serNumDate', function($join){
            												$join->on('ms.serial_number', '=', 'serNumDate.serial_number');
                    										$join->on('ms.created_date', '=', 'serNumDate.dt');})
    				
            		->whereIn('ms.serial_number', function($query) use ($org_id, $year){                    
                        									$query->select('serial_number')
                                                                ->from('machine_archive')
                              									->where('org_id', '=', $org_id)
                              									->where('school_year', '=', $year);
                        									})
        			->where('service_needed', '=', '1')->get();
		/*********************************** END SERVICE_DATA ************************************/
        	   	
    
    	/*********************************** BEGIN CONTRACT_DEVICES ************************************/
    	$contract_devices = DB::table($yearTab . '_floorplan_machines as fpm')
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
        				->whereNotNull('fpm.fyer_group_id')->get();
    	/*********************************** END CONTRACT_DEVICES ************************************/
    
    
    
    	/*********************************** BEGIN NON_CONTRACT_DEVICES ************************************/
    	$non_contract_devices = DB::table($yearTab . '_floorplan_machines as fpm')
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
        				->whereNull('fpm.fyer_group_id')->get();
    	/*********************************** END NON_CONTRACT_DEVICES ************************************/
    
    	
    
    	/*********************************** BEGIN LAST_SYNC_DATE ************************************/
        $last_sync_date = DB::table('meters as mtr')
                       	->select(DB::raw('max(created_date) as dt'))        				
        				->whereIn('mtr.serial_number', function($query) use ($yearTab, $org_id){
            											$query->select('fm.serial_number')
                                                    	->from($yearTab . '_floorplan_machines as fm')
                                                        ->join('floorplans as fp', 'fp.id', '=', 'fm.floorplans_id')
                                                        ->join('buildings as bldg', 'bldg.id', '=', 'fp.buildings_id')
                                                    	->where('bldg.organizations_id', '=', $org_id)
                                                        ->whereNotNull('fm.serial_number')
                                                        ->where('fm.serial_number', '!=', '');
            										})->first('dt');
    	/*********************************** END LAST_SYNC_DATE ************************************/
    
    
    
    	
    	/*********************************** BEGIN VOLUME_TOTALS ************************************/
    	$volume_totals = DB::table('machine_archive')
        				->select(DB::raw('SUM(projected_volume_black) as budget_blk, SUM(projected_volume_color) as budget_col,
                                        SUM(meter_end_read_black - meter_begin_read_black) as consumed_blk,
                                        SUM(meter_end_read_color - meter_begin_read_color) as consumed_col'))
        				->whereIn('serial_number', function($query) use($year, $yearTab, $org_id){
                        									$query->select('fpm.serial_number')
                                                            ->from($yearTab . '_floorplan_machines as fpm')
                                                            ->join('floorplans as fp', 'fp.id', '=', 'fpm.floorplans_id')
                                                            ->join('buildings as bldgs', 'bldgs.id', '=', 'fp.buildings_id')
                                                            ->where('bldgs.organizations_id', '=', $org_id);
                        							})
        				->where('school_year', '=', $year)->first();
    
    	$budget_black = number_format($volume_totals->budget_blk,0 ,0, ',');
    	$budget_color = number_format($volume_totals->budget_col,0 ,0, ',');
    	$cons_black = number_format($volume_totals->consumed_blk,0 ,0, ',');
    	$cons_color = number_format($volume_totals->consumed_col,0 ,0, ',');
    	/*********************************** END VOLUME_TOTALS ************************************/
    	
   	
    
    	
    	
    	/*Used as a subquery in devices_reporting and not_reporting queries*/
    	$lastMeterRead = DB::table($yearTab . '_meters')
                       ->select(DB::raw('max(created_date) as dt, serial_number'))           
                       ->groupBy('serial_number');
    
    
    	
    	/*********************************** BEGIN NOT_REPORTING ************************************/
    	$not_reporting = DB::table($yearTab . '_meters as m')// Carbon::now()->subDays(30)
        				->join($yearTab . '_floorplan_machines as fpm', 'fpm.serial_number', '=', 'm.serial_number')
        				->joinSub($lastMeterRead, 'lastMeterRead', function($join){
            												$join->on('m.serial_number', '=', 'lastMeterRead.serial_number');
                    										$join->on('m.created_date', '=', 'lastMeterRead.dt');})
       					->join('floorplans as fp', 'fp.id', '=', 'fpm.floorplans_id')
        				->join('buildings as bldgs', 'bldgs.id', '=', 'fp.buildings_id')
        				->where('bldgs.organizations_id', '=', $org_id)
        				->where('fpm.machines_id', '!=', 790)
        				->whereNotNull('fpm.fyer_group_id')
        				->where('m.created_date', '<', '2019-06-15 00:00:00')->get();
    	/*********************************** END NOT_REPORTING ************************************/
    
    
    
    	
    	/*********************************** BEGIN DEVICES_REPORTING ************************************/
    	$devices_reporting = DB::table($yearTab . '_meters as m')// Carbon::now()->subDays(30)
        				->join($yearTab . '_floorplan_machines as fpm', 'fpm.serial_number', '=', 'm.serial_number')
        				->joinSub($lastMeterRead, 'lastMeterRead', function($join){
            												$join->on('m.serial_number', '=', 'lastMeterRead.serial_number');
                    										$join->on('m.created_date', '=', 'lastMeterRead.dt');})
       					->join('floorplans as fp', 'fp.id', '=', 'fpm.floorplans_id')
        				->join('buildings as bldgs', 'bldgs.id', '=', 'fp.buildings_id')
        				->where('bldgs.organizations_id', '=', $org_id)
        				->where('fpm.machines_id', '!=', 790)
        				->whereNotNull('fpm.fyer_group_id')
        				->where('m.created_date', '>=', '2019-06-15 00:00:00')->get();
    
    	/*********************************** END DEVICES_REPORTING ************************************/
    
        	
    	     
    	/*To get the total of devices w/toner alert, count the records in the array(resultset)*/
		$toner_alert_count = $toner_data->count();
		$service_needed_count = $service_data->count();
    	$contract_devices_count = $contract_devices->count();
    	$non_contract_devices_count = $non_contract_devices->count();
    	$devices_reporting_count = $devices_reporting->count();
    	$not_reporting_count = $not_reporting->count();
    
    		                        
     	return view('gauges.show', compact('fp_data', 'org_id', 'year', 'yearTab', 'color', 'toner_alert_count', 'service_needed_count',
                                           'contract_devices_count', 'non_contract_devices_count', 'devices_reporting_count', 'not_reporting_count'))
			->with('floorplans', Floorplan::all())
			->with('bldgs', Building::orderBy('bldg_name')->get()->where('organizations_id', $org_id))
     		->with('years', SchoolYear::orderBy('id')->get())        
			->with('orgs', Organization::orderBy('org_name')->get()->where('client_status', 'A'));	    
    		
    }

	
	public function show_by_year($year)
    {
		/*Concat Y20 to the 2 digit year variable. This will be the prefix for all of the year specific tables in queries.*/	
   		 $yearTab = 'Y20' . $year;   
    	
    
    	/*When a different year is selected, reset the year and year_table variables.*/
    	session(['year' => $year]);
    	session(['yearTab' => $yearTab]);
    	
    	$org_id = session('org_id');
    	$color = session('color');
    	$fp_data = 72;
		    	 
    
    	//$serNumDate = DB::table('Y2019_machine_status')
        $serNumDate = DB::table($yearTab . '_machine_status')
                       ->select(DB::raw('max(created_date) as dt, serial_number'))           
                       ->groupBy('serial_number');
                       //->get(); This changes the $serNumDate from a string so an error occurs
    
    
    	$toner_data = DB::table($yearTab . '_machine_status AS ms')
    				->joinSub($serNumDate, 'serNumDate', function($join){
            												$join->on('ms.serial_number', '=', 'serNumDate.serial_number');
                    										$join->on('ms.created_date', '=', 'serNumDate.dt');})
    				
            		->whereIn('ms.serial_number', function($query) use ($org_id, $year){                    
                        									$query->select('serial_number')
                                                                ->from('machine_archive')
                              									->where('org_id', '=', $org_id)
                              									->where('school_year', '=', $year);
                        									})
        			->where('toner', '=', '1')->get();
        
		/*This is the same query as for toner_data except that the last where clause is specific to service_needed instead of toner.*/
		$service_data = DB::table($yearTab . '_machine_status AS ms')
    				->joinSub($serNumDate, 'serNumDate', function($join){
            												$join->on('ms.serial_number', '=', 'serNumDate.serial_number');
                    										$join->on('ms.created_date', '=', 'serNumDate.dt');})
    				
            		->whereIn('ms.serial_number', function($query) use ($org_id, $year){                    
                        									$query->select('serial_number')
                                                                ->from('machine_archive')
                              									->where('org_id', '=', $org_id)
                              									->where('school_year', '=', $year);
                        									})
        			->where('service_needed', '=', '1')->get();


		$contract_devices = DB::table($yearTab . '_floorplan_machines as fpm')
        	->whereIn('fpm.serial_number', function($query) use ($org_id, $year){
            										$query->select('serial_number')
                                                    	->from('machine_archive')
                                                    	->where('org_id', '=', $org_id)
                                                        ->where('school_year', '=',  $year);
            										})
        	->where('fpm.machines_id', '!=', 790)
        	->whereNotNull('fpm.fyer_group_id')->get();
    
    
    	$non_contract_devices = DB::table($yearTab . '_floorplan_machines as fpm')     					
     		
     		->join($yearTab . '_machine_status as ms', 'ms.serial_number', '=', 'fpm.serial_number')
     		->joinSub($serNumDate, 'serNumDate', function($join){
            												$join->on('ms.serial_number', '=', 'serNumDate.serial_number');
                    										$join->on('ms.created_date', '=', 'serNumDate.dt');})
     
     					->join('floorplans as fp', 'fp.id', '=', 'fpm.floorplans_id')
     					->join('machines as mach', 'mach.id', '=', 'fpm.machines_id')
     					->join('buildings as bldg', 'bldg.id', '=', 'fp.buildings_id')
     					->join('organizations as orgs', 'orgs.id', '=', 'bldg.organizations_id')
     					
        				->whereIn('fpm.serial_number', function($query) use ($org_id, $year){
            											$query->select('serial_number')
                                                    	->from('machine_archive')
                                                    	->where('org_id', '=', $org_id)
                                                        ->where('school_year', '=',  $year);
            										})        				
        				->whereNull('fpm.fyer_group_id')->get();
		
        
		/*To get the total of devides w/toner alert, count the records in the array(resultset)*/
		$toner_alert_count = $toner_data->count();
		$service_needed_count = $service_data->count();
		$contract_devices_count = $contract_devices->count();
    	$non_contract_devices_count = $non_contract_devices->count();
    		                        
     	return view('gauges.show', compact('fp_data', 'org_id', 'year', 'yearTab', 'toner_alert_count', 'service_needed_count', 'contract_devices_count', 'non_contract_devices_count', 'color'))
			->with('floorplans', Floorplan::all())
			->with('bldgs', Building::orderBy('bldg_name')->get()->where('organizations_id', $org_id))
     		->with('years', SchoolYear::orderBy('id')->get())
			->with('orgs', Organization::orderBy('org_name')->get()->where('client_status', 'A'));
    }

	public function show_by_color($color)
    {
				
    	session(['color' => $color]);
    	$org_id = session('org_id');
    	$year = session('year');
    	$yearTab = session('yearTab');
    	$fp_data = 72;
		    	 
    
    	$serNumDate = DB::table($yearTab . '_machine_status')
                       ->select(DB::raw('max(created_date) as dt, serial_number'))           
                       ->groupBy('serial_number');
                       //->get(); This changes the $serNumDate from a string so an error occurs
    
    
    	$toner_data = DB::table($yearTab . '_machine_status AS ms')
    				->joinSub($serNumDate, 'serNumDate', function($join){
            												$join->on('ms.serial_number', '=', 'serNumDate.serial_number');
                    										$join->on('ms.created_date', '=', 'serNumDate.dt');})
    				
            		->whereIn('ms.serial_number', function($query) use ($org_id, $year){                    
                        									$query->select('serial_number')
                                                                ->from('machine_archive')
                              									->where('org_id', '=', $org_id)
                              									->where('school_year', '=', $year);
                        									})
        			->where('toner', '=', '1')->get();
        
		/*This is the same query as for toner_data except that the last where clause is specific to service_needed instead of toner.*/
		$service_data = DB::table($yearTab . '_machine_status AS ms')
    				->joinSub($serNumDate, 'serNumDate', function($join){
            												$join->on('ms.serial_number', '=', 'serNumDate.serial_number');
                    										$join->on('ms.created_date', '=', 'serNumDate.dt');})
    				
            		->whereIn('ms.serial_number', function($query) use ($org_id, $year){                    
                        									$query->select('serial_number')
                                                                ->from('machine_archive')
                              									->where('org_id', '=', $org_id)
                              									->where('school_year', '=', $year);
                        									})
        			->where('service_needed', '=', '1')->get();


		$contract_devices = DB::table($yearTab . '_floorplan_machines as fpm')
        	->whereIn('fpm.serial_number', function($query) use ($org_id, $year){
            										$query->select('serial_number')
                                                    	->from('machine_archive')
                                                    	->where('org_id', '=', $org_id)
                                                        ->where('school_year', '=',  $year);
            										})
        	->where('fpm.machines_id', '!=', 790)
        	->whereNotNull('fpm.fyer_group_id')->get();
    
    
    	$non_contract_devices = DB::table($yearTab . '_floorplan_machines as fpm')     					
     		
     		->join($yearTab . '_machine_status as ms', 'ms.serial_number', '=', 'fpm.serial_number')
     		->joinSub($serNumDate, 'serNumDate', function($join){
            												$join->on('ms.serial_number', '=', 'serNumDate.serial_number');
                    										$join->on('ms.created_date', '=', 'serNumDate.dt');})
     
     					->join('floorplans as fp', 'fp.id', '=', 'fpm.floorplans_id')
     					->join('machines as mach', 'mach.id', '=', 'fpm.machines_id')
     					->join('buildings as bldg', 'bldg.id', '=', 'fp.buildings_id')
     					->join('organizations as orgs', 'orgs.id', '=', 'bldg.organizations_id')
     					
        				->whereIn('fpm.serial_number', function($query) use ($org_id, $year){
            											$query->select('serial_number')
                                                    	->from('machine_archive')
                                                    	->where('org_id', '=', $org_id)
                                                        ->where('school_year', '=',  $year);
            										})        				
        				->whereNull('fpm.fyer_group_id')->get();
		
        
		/*To get the total of devides w/toner alert, count the records in the array(resultset)*/
		$toner_alert_count = $toner_data->count();
		$service_needed_count = $service_data->count();
		$contract_devices_count = $contract_devices->count();
    	$non_contract_devices_count = $non_contract_devices->count();
    		                        
     	return view('gauges.show', compact('fp_data', 'org_id', 'year', 'yearTab', 'color', 'toner_alert_count', 'service_needed_count', 'contract_devices_count'))
			->with('floorplans', Floorplan::all())
			->with('bldgs', Building::orderBy('bldg_name')->get()->where('organizations_id', $org_id))
     		->with('years', SchoolYear::orderBy('id')->get())
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
