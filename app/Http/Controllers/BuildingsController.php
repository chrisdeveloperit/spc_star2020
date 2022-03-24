<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateBuildingRequest;
use Illuminate\Support\Facades\DB;

use App\Models\Building;
use App\Models\Address;
use App\Models\Organization;
use App\Models\Floorplan;
use App\Models\Phone;
use App\Models\OrgContact;
use App\Models\Contact_x_Building;


class BuildingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*Create the subquery for main phones*/
		/*$phones = DB::table('phones AS ph')
        	->select('ph.owner_id', 'ph.area_code', 'ph.exch', 'ph.phone_line')
        	->where('ph.owner_type', '=', 'B')
        	->where('ph.phone_type', '=', 'M');*/
			
			
    	/*Create the subquery for faxes*/		
        /*$faxes = DB::table('phones AS fax')			
        	->select('fax.owner_id', 'fax.area_code AS f_area_code', 'fax.exch AS f_exch', 'fax.phone_line AS f_phone_line')			
        	->where('fax.owner_type', '=', 'B')
        	->where('fax.phone_type', '=', 'F');*/
			
			
		/*Create the subquery for addresses*/
		$addresses = DB::table('addresses AS addr')
			->select('addr.owner_id', 'addr.address', 'addr.address2', 'addr.city', 'addr.state',
				'addr.zip_code', 'addr.county')
			->where('addr.owner_type', '=', 'B')
			->where('addr.address_type', '=', 'L');
			
		
		/*Create the subquery for addressesMail for Mailing (po box) addresses*/
		$addressesMail = DB::table('addresses AS addrM')
			->select('addrM.owner_id AS owner_id_mail', 'addrM.address AS address_mail', 'addrM.address2 AS address2_mail', 'addrM.city AS city_mail',
			    'addrM.state AS state_mail', 'addrM.zip_code AS zip_code_mail', 'addrM.county AS county_mail')
			->where('addrM.owner_type', '=', 'B')
			->where('addrM.address_type', '=', 'M');
			
		$contact = DB::table('contacts_x_buildings AS contacts')
		    ->select('contacts.contacts_id', 'contacts.buildings_id')
		    ->where('contacts.contact_type', '=', 'bldg_contact');
			
			
		$bldg_data = DB::table('organizations')
				->join('buildings', 'buildings.organizations_id', '=', 'organizations.org_id')
				->leftJoinSub($addresses, 'addr', function($join){
				$join->on('buildings.bldg_id', '=', 'addr.owner_id');
			})
			
			->leftJoinSub($addressesMail, 'addrM', function($join){
				$join->on('buildings.bldg_id', '=', 'addrM.owner_id_mail');
			})
			
			/*->leftJoinSub($phones, 'main', function($join){
			    $join->on('buildings.bldg_id', '=', 'main.owner_id');
			})
			
			->leftJoinSub($faxes, 'fax', function($join){
			    $join->on('buildings.bldg_id', '=', 'fax.owner_id');
			})*/
			
			->leftJoinSub($contact, 'contact', function($join){
			    $join->on('buildings.bldg_id', '=', 'contact.buildings_id');
			})
								
		    ->where('buildings.deleted_at', NULL)
		    ->orderBy('buildings.bldg_name')->get();
		
		return view('buildings.index', compact('bldg_data'))->with('orgs', Organization::orderBy('org_name')->get()->where('client_status', 'A'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$bldg_data = DB::table('organizations')
				->join('buildings', function ($join){
								$join->on('buildings.organizations_id', '=', 'organizations.org_id')
								->select('buildings.*', 'organizations.org_name');								
								})
				->get();
				
		return view('buildings.create', compact('bldg_data'))->with('orgs', Organization::orderBy('org_name')->get()->where('client_status', 'A'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBuildingRequest $request)
    {
        /*echo $request->bldgNotes;*/
        
        /* When Inserting a building, first check to see if the org exists. Add the building_contact person to contacts_x_buildings. Add
            the addresses and phones to their respective tables as well.*/ 
        
       $this->validate($request,
			['organizations_id'=>'required',
				'bldg_name'=>'required'
			]);
			
			
	
		Building::create([
			'organizations_id'=>$request->organizations_id,
			'bldg_name'=>$request->bldg_name,
			'bldg_name_short'=>$request->bldgNameShort,
			'student_pop'=>$request->studentPop,
			'bldg_equip_cost'=>$request->equipCost,
			'notes'=>$request->bldgNotes,
			'created_date'=>NOW(),
			'created_by'=>1271,
			'modified_date'=>NOW(),
			'modified_by'=>1271
		]);
		
		$new_bldg_id = DB::getPdo()->lastInsertId();
	    
	   
	   /*Insert the bldg_contact into the contacts table, then use the new id to
	        insert a record into the contacts_x_buildings table.*/
	   if(isset($request->firstName)){
    	   OrgContact::create([
    	        'buildings_id'=>$new_bldg_id,
    	        'last_name'=>$request->lastName,
    	        'first_name'=>$request->firstName,
    	        'email'=>$request->email,
    	        'org_job_title'=>$request->jobTitle,
    	        'notes'=>$request->contactNotes,
    	        'stardoc_user_id'=>$request->stardocId,
    	        'email_group_id'=>$request->emailGroupId,
    	        'created_date'=>NOW(),
    			'created_by'=>1271,
    			'modified_date'=>NOW(),
    			'modified_by'=>1271
    	    ]);
    	    
    	    $new_contact_id = DB::getPdo()->lastInsertId();
	    
    	    Contact_x_Building::create([
    	        'contact_type'=>'bldg_contact',
    	        'contacts_id' =>$new_contact_id,
    	        'buildings_id'=>$new_bldg_id,
    	        'created_date'=>NOW(),
    			'created_by'=>1271,
    			'modified_date'=>NOW(),
    			'modified_by'=>1271
    	    ]);
	   }
	    
	    
		
		/*Insert the first address.*/
		if(isset($request->address)){
    		Address::create([
    		    'owner_type'=>'B',
    			'owner_id'=>$new_bldg_id,
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
		
	    
		//$new_address_id = DB::getPdo()->lastInsertId();
        //echo $new_address_id;
		
		
		/*Insert the 2nd address if there is one.*/
		if(isset($request->address_2)){
		    Address::create([
		    'owner_type'=>'B',
			'owner_id'=>$new_bldg_id,
			'address_type'=>$request->addrType_2,
			'address'=>$request->address_2,
			'address2'=>$request->address2_2,
			'city'=>$request->city_2,
			'state'=>$request->state_2,
			'zip_code'=>$request->zip_2,
			'county'=>$request->county_2,
			'created_date'=>NOW(),
			'created_by'=>1271,
			'modified_date'=>NOW(),
			'modified_by'=>1271
		    ]);
		}
		
		
		/*Insert the phone data for the first phone, if there is one*/
		if(isset($request->areaCode)){
		    Phone::create([
		    'owner_type'=>'B',
			'owner_id'=>$new_bldg_id,
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
		    'owner_type'=>'B',
			'owner_id'=>$new_bldg_id,
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
		
		session()->flash('success', 'New building record successfully created');
		
		return redirect(route('buildings.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
		/*Create the subquery for main phones*/
		/*$phones = DB::table('phones AS ph')
        	->select('ph.owner_id', 'ph.area_code', 'ph.exch', 'ph.phone_line')
        	->where('ph.owner_type', '=', 'O')
        	->where('ph.phone_type', '=', 'M');*/
			
			
    	/*Create the subquery for faxes*/		
        /*$faxes = DB::table('phones AS fax')			
        	->select('fax.owner_id', 'fax.area_code AS f_area_code', 'fax.exch AS f_exch', 'fax.phone_line AS f_phone_line')			
        	->where('fax.owner_type', '=', 'O')
        	->where('fax.phone_type', '=', 'F');*/
			
			
		/*Create the subquery for addresses*/
		$addresses = DB::table('addresses AS addr')
			->select('addr.owner_id', 'addr.address', 'addr.address2', 'addr.city', 'addr.state',
				'addr.zip_code', 'addr.county')
			->where('addr.owner_type', '=', 'B')
			->where('addr.address_type', '=', 'L');
			
		
		/*Create the subquery for addressesMail for Mailing (po box) addresses*/
		$addressesMail = DB::table('addresses AS addrM')
			->select('addrM.owner_id AS owner_id_mail', 'addrM.address AS address_mail', 'addrM.address2 AS address2_mail', 'addrM.city AS city_mail',
			    'addrM.state AS state_mail', 'addrM.zip_code AS zip_code_mail', 'addrM.county AS county_mail')
			->where('addrM.owner_type', '=', 'B')
			->where('addrM.address_type', '=', 'M');
			
		/*Create the subquery for contact*/
		$contact = DB::table('contacts_x_buildings AS contacts')
		    ->select('contacts.contacts_id', 'contacts.buildings_id')
		    ->where('contacts.contact_type', '=', 'bldg_contact');
			
			
		
		$bldg_data = DB::table('buildings')
				->join('organizations', function ($join) use ($id){
								$join->on('buildings.organizations_id', '=', 'organizations.org_id')
								->select('buildings.*', 'organizations.org_name')
								->where('organizations_id', '=', DB::raw($id));
				})
				
		/*$bldg_data = DB::table('organizations')
				->join('buildings', 'buildings.organizations_id', '=', 'organizations.org_id')
				->leftJoinSub($addresses, 'addr', function($join){
				    $join->on('buildings.bldg_id', '=', 'addr.owner_id')
				->where('organizations_id', '=', DB::raw($id));
			})*/
				
		
			->leftJoinSub($addresses, 'addr', function($join){
				$join->on('buildings.bldg_id', '=', 'addr.owner_id');
			})
			
			
			->leftJoinSub($addressesMail, 'addrM', function($join){
				$join->on('buildings.bldg_id', '=', 'addrM.owner_id_mail');
			})
			
			/*->leftJoinSub($phones, 'main', function($join){
			    $join->on('buildings.bldg_id', '=', 'main.owner_id');
			})*/
			
			/*->leftJoinSub($faxes, 'fax', function($join){
			    $join->on('buildings.bldg_id', '=', 'fax.owner_id');
			})*/
			
			->leftJoinSub($contact, 'contact', function($join){
			    $join->on('buildings.bldg_id', '=', 'contact.buildings_id');
			})
								
		    ->where('organizations_id', '=', DB::raw($id))
		    ->where('buildings.deleted_at', NULL)
		    ->orderBy('buildings.bldg_name')->get();
				
		
		return view('buildings.index', compact(['bldg_data', 'id']))->with('orgs', Organization::orderBy('org_name')->get()->where('client_status', 'A'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Building $building)
    {
        return view('buildings.create')->with('buildings', $building)
        ->with('orgs', Organization::orderBy('org_name')->get()->where('client_status', 'A'));
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
        /* When updating a building, first check to see if the org is being updated. If so, make sure the org exists in the organization table.
            Update the building_contact person in contacts_x_buildings, if it is different. Update the addresses and phones in their respective tables as well.*/ 
        
        $buildings = Building::find($id);        
        
        $buildings->update([			
            'bldg_name' => $request->bldgName,
			'bldg_name_short' => $request->bldg_name_short,
			'bldg_contact_id' => $request->bldgContact,
            'student_pop' => $request->studentPop,
            'bldg_equip_cost' => $request->equipCost,
            //'notes' => $request->bldg_name_short,,
            'modified_date' => NOW(),
			'modified_by' => 1271
		]);
		
		$buildings->save();
		
		session()->flash('success', 'Building record was successfully updated');
		
		return redirect(route('buildings.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /* To cascade the deletes so no orphan data is left when a parent building is deleted - -
            When deleting a building, delete the building_contact person from the contacts_x_buildings table.
            Delete the addresses and phones from their respective tables as well.
            To soft delete, use the update method. SoftDelete does not work with DB::raw.*/
            
        DB::update('update contacts_x_buildings set deleted_at = ? where buildings_id = ?', [now(), $id]);
        DB::update('update addresses set deleted_at = ? where owner_type = ? AND owner_id = ?', [now(), 'B', $id]);
        DB::update('update phones set deleted_at = ? where owner_type = ? AND owner_id = ?', [now(), 'B', $id]);
        
        Building::destroy($id);
		
		session()->flash('success', 'Building record successfully deleted');		
		
		return redirect(route('buildings.index'));
    }
}
