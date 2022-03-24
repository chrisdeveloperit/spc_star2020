<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SpcUser;
use App\Models\Organization;
use App\Models\Building;
use DB;

class SPCUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$data = DB::table('spc_users')
            ->join('organizations', 'organizations.org_id', '=', 'organizations.organization_types_id');
        
        return view('spc_users.index', compact('data'))
			->with('orgs', Organization::orderBy('org_name')->get());*/
			
		return view('spc_users.index')->with('orgs', Organization::orderBy('org_name')->get()->where('client_status', 'A'));
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
        /*Create the subquery for buildings*/
		$buildings = DB::table('buildings AS bldg')
		    ->join('organizations', 'organizations.org_id', '=', 'bldg.organizations_id')
			->select('bldg.bldg_id', 'bldg.bldg_name', 'bldg.organizations_id');
			
		/*Create the subquery for it_contacts, which will populate the info above the table*/
		$it_contacts = DB::table('spc_users')
		    ->select('spc_users.peo_id AS spc_peo_id', 'spc_users.first_name AS spc_first_name', 'spc_users.last_name AS spc_last_name',
		        'spc_users.position AS spc_position', 'spc_users.email AS spc_email')
		    ->where('spc_users.position', 'LIKE', '%IT%')
		    ->where('spc_users.organizations_id', '=', DB::raw($id));
		
		
		/*Create the subquery for main phones*/
		$phones = DB::table('phones AS ph')
        	->select('ph.owner_id', 'ph.area_code', 'ph.exch', 'ph.phone_line')
        	->where('ph.owner_type', '=', 'U')
        	->where('ph.phone_type', '=', 'M');
		
	
		/*works good - - $userdata = DB::table('spc_users')
	                ->join('organizations', 'organizations.org_id', '=', 'spc_users.organizations_id')
	                ->leftJoinSub($buildings, 'bldg', function($join){
				        $join->on('bldg.bldg_id', '=', 'spc_users.buildings_id');
	                })
				    ->where('spc_users.organizations_id', '=', DB::raw($id))
				    ->where('spc_users.deleted_date', '=', NULL)
			        ->get();*/
			        
		
		$userdata = DB::table('spc_users')
	                ->join('organizations', 'organizations.org_id', '=', 'spc_users.organizations_id')
	                ->leftJoinSub($buildings, 'bldg', function($join){
				        $join->on('bldg.bldg_id', '=', 'spc_users.buildings_id');
	                })
	                ->leftJoinSub($it_contacts, 'itc', function($join){
	                    $join->on('itc.spc_peo_id', '=', 'spc_users.peo_id');
	                })
	                
	                ->leftJoinSub($phones, 'main', function($join){
        			    $join->on('spc_users.peo_id', '=', 'main.owner_id');
        			})
				    ->where('spc_users.organizations_id', '=', DB::raw($id))
				    ->where('spc_users.deleted_at', '=', NULL)
			        ->get();	    
		
	    
	    return view('spc_users.index', compact('userdata'))
			->with('orgs', Organization::orderBy('org_name')->where('client_status', 'A')->get());
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
