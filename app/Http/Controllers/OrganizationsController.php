<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateOrganizationRequest;
use Illuminate\Support\Facades\DB;

use App\Models\Organization;
use App\Models\OrganizationType;
use App\Models\Phone;
use App\Models\Address;


class OrganizationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {       
		
		/*Create the subquery for main phones*/
		$phones = DB::table('phones AS ph')
        	->select('ph.owner_id', 'ph.area_code', 'ph.exch', 'ph.phone_line')
        	->where('ph.owner_type', '=', 'O')
        	->where('ph.phone_type', '=', 'M');
			
			
    	/*Create the subquery for faxes*/		
        $faxes = DB::table('phones AS fax')			
        	->select('fax.owner_id', 'fax.area_code AS f_area_code', 'fax.exch AS f_exch', 'fax.phone_line AS f_phone_line')			
        	->where('fax.owner_type', '=', 'O')
        	->where('fax.phone_type', '=', 'F');
			
			
		/*Create the subquery for addresses*/
		$addresses = DB::table('addresses AS addr')
			->select('addr.owner_id', 'addr.address', 'addr.address2', 'addr.city', 'addr.state',
				'addr.zip_code', 'addr.county')
			->where('addr.owner_type', '=', 'O')
			->where('addr.address_type', '=', 'L');
			
		
		/*Create the subquery for addressesMail for Mailing (po box) addresses*/
		$addressesMail = DB::table('addresses AS addrM')
			->select('addrM.owner_id AS owner_id_mail', 'addrM.address AS address_mail', 'addrM.address2 AS address2_mail', 'addrM.city AS city_mail',
			    'addrM.state AS state_mail', 'addrM.zip_code AS zip_code_mail', 'addrM.county AS county_mail')
			->where('addrM.owner_type', '=', 'O')
			->where('addrM.address_type', '=', 'M');
			
		
		/*Create the main query that joins the 2 subqueries to organizations*/
		$orgdata = DB::table('organization_types')
            ->join('organizations', 'organization_types.org_type_id', '=', 'organizations.organization_types_id')
		
			->leftJoinSub($addresses, 'addr', function($join){
				$join->on('organizations.org_id', '=', 'addr.owner_id');
			})
			
			->leftJoinSub($addressesMail, 'addrM', function($join){
				$join->on('organizations.org_id', '=', 'addrM.owner_id_mail');
			})
			
			->leftJoinSub($phones, 'main', function($join){
			    $join->on('organizations.org_id', '=', 'main.owner_id');
			})
			
			->leftJoinSub($faxes, 'fax', function($join){
			    $join->on('organizations.org_id', '=', 'fax.owner_id');
			})
			
			
			->where('client_status', '=', 'A')
			->where('organizations.deleted_at', NULL)
			->orderBy('organizations.org_name')->get();
		
		return view('organizations.index', compact('orgdata'))
			->with('data', OrganizationType::orderBy('org_type_name')->get());
		
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		return view('organizations.create')->with('org_types', OrganizationType::orderBy('org_type_name')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrganizationRequest $request)
    {
        /* When Inserting an org, these tables also need to be touched. org_contacts, buildings, departments, addresses, and phones.*/
        	Organization::create([
			'org_name'=>$request->org_name,
			'org_short_name'=>$request->orgShortName,
			'organization_types_id'=>$request->organizations_type_id,
			'website'=>$request->website,
			'fmaudit_client_id'=>$request->fmaudit_client_id,
			'commencement_date'=>$request->commencement_date,
			'client_since'=>$request->client_since,
			'client_status'=>$request->clientStatusSel,
			
			'print_mgmt_software_installed'=>$request->printMgmtSel,
			'lenp_contract_signed'=>$request->lenPSel,
			'display_meter_data'=>$request->mtrDataSel,
			'client_logo'=>$request->clientLogo,
			'gm_notes'=>$request->gmNotes,
			'org_message'=>$request->orgMsg,
			'bank_buyout'=>$request->bankBuy,
			'spc_service_fee'=>$request->spcSvcFee,
			'trade_out_deletion'=>$request->tradeOut,
			'new_upgrade_date'=>$request->newUpgrade,
			'temp_inactive'=>$request->tempInactiveSel,
			'created_date'=>NOW(),
			'created_by'=>1271,
			'modified_date'=>NOW(),
			'modified_by'=>1271
		]);
		
		$new_org_id = DB::getPdo()->lastInsertId();
        
        /*Insert the address.*/
		if(isset($request->address)){
    		Address::create([
    		    'owner_type'=>'O',
    			'owner_id'=>$new_org_id,
    			'address_type'=>$request->addrType,
    			'address'=>$request->address,
    			'address2'=>$request->address2,
    			'city'=>$request->city,
    			'state'=>$request->state,
    			'zip_code'=>$request->zip,
    			'county'=>$request->county,
    			'created_date'=>NOW(),
    			'created_by'=>1271,
    			'modified_date'=>NOW(),
    			'modified_by'=>1271
    		]);
		}	    
        
        /*Insert the phone data for the first phone, if there is one*/
		if(isset($request->areaCode)){
		    Phone::create([
		    'owner_type'=>'O',
			'owner_id'=>$new_org_id,
			'phone_type'=>$request->phType,
			'area_code'=>$request->areaCode,
			'exch'=>$request->exchange,
			'phone_line'=>$request->phLine,
			'extension'=>$request->extension,
			'created_date'=>NOW(),
			'created_by'=>1271,
			'modified_date'=>NOW(),
			'modified_by'=>1271
		    ]);
		}
		
		/*Insert the 2nd phone if there is one.*/
		if(isset($request->areaCode_2)){
		    Phone::create([
		    'owner_type'=>'O',
			'owner_id'=>$new_org_id,
			'phone_type'=>$request->phType_2,
			'area_code'=>$request->areaCode_2,
			'exch'=>$request->exchange_2,
			'phone_line'=>$request->phLine_2,
			'extension'=>$request->extension_2,
			'created_date'=>NOW(),
			'created_by'=>1271,
			'modified_date'=>NOW(),
			'modified_by'=>1271
		    ]);
		}
		
		session()->flash('success', 'New organization record successfully created');
		//session()->flash('error', 'New organization record was not created');
		
		return redirect(route('organizations.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($type_id)
    {					
		/*Create the subquery for main phones*/
		$phones = DB::table('phones AS ph')
        	->select('ph.owner_id', 'ph.area_code', 'ph.exch', 'ph.phone_line')
        	->where('ph.owner_type', '=', 'O')
        	->where('ph.phone_type', '=', 'M');
			
			
    	/*Create the subquery for faxes*/		
        $faxes = DB::table('phones AS fax')			
        	->select('fax.owner_id', 'fax.area_code AS f_area_code', 'fax.exch AS f_exch', 'fax.phone_line AS f_phone_line')			
        	->where('fax.owner_type', '=', 'O')
        	->where('fax.phone_type', '=', 'F');
			
			
		$addresses = DB::table('addresses AS addr')
			->select('addr.owner_id', 'addr.address', 'addr.address2', 'addr.city', 'addr.state',
				'addr.zip_code', 'addr.county')
			->where('addr.owner_type', '=', 'O')
			->where('addr.address_type', '=', 'L');
			
		
		$addressesMail = DB::table('addresses AS addrM')
			->select('addrM.owner_id AS owner_id_mail', 'addrM.address AS address_mail', 'addrM.address2 AS address2_mail', 'addrM.city AS city_mail',
			    'addrM.state AS state_mail', 'addrM.zip_code AS zip_code_mail', 'addrM.county AS county_mail')
			->where('addrM.owner_type', '=', 'O')
			->where('addrM.address_type', '=', 'M');
		
		
		$orgdata = DB::table('organization_types')
            ->join('organizations', 'organization_types.org_type_id', '=', 'organizations.organization_types_id')
			
			->leftJoinSub($addresses, 'addr', function($join){
				$join->on('organizations.org_id', '=', 'addr.owner_id');
			})
			
			->leftJoinSub($addressesMail, 'addrM', function($join){
				$join->on('organizations.org_id', '=', 'addrM.owner_id_mail');
			})
			
			->leftJoinSub($phones, 'main', function($join){
			    $join->on('organizations.org_id', '=', 'main.owner_id');
			})
			
			->leftJoinSub($faxes, 'fax', function($join){
			    $join->on('organizations.org_id', '=', 'fax.owner_id');
			})
			
			->where('organizations.deleted_at', NULL)
			->where('client_status', 'A')
			->where('org_type_id', '=', DB::raw($type_id))->get();
			
		
		return view('organizations.index', compact('orgdata', 'type_id'))
			->with('data', OrganizationType::orderBy('org_type_name')->get());
		
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
        /* When updating an org, these tables also need to be touched. org_contacts, buildings, departments, addresses, and phones.*/ 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /* To cascade the deletes so no orphan data is left when a parent organization is deleted - -
            When deleting an org, delete the buildings, departments, addresses and phones from their respective tables.
            To soft delete, use the update method. SoftDelete does not work with DB::raw.*/
        
        DB::update('update buildings set deleted_at = ? where organizations_id = ?', [now(), $id]);    
        DB::update('update departments set deleted_at = ? where organizations_id = ?', [now(), $id]);
        DB::update('update addresses set deleted_at = ? where owner_type = ? AND owner_id = ?', [now(), 'O', $id]);
        DB::update('update phones set deleted_at = ? where owner_type = ? AND owner_id = ?', [now(), 'O', $id]);
        
        Organization::destroy($id);
		
		session()->flash('success', 'Organization record successfully deleted');		
		
		return redirect(route('organizations.index'));
        
    }
}
