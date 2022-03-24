<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\customRequests\ShowContactRequest;
use App\Http\Requests\CreateOrgContactRequest;
use Illuminate\Support\Facades\DB;

use App\Models\Address;
use App\Models\OrgContact;
use App\Models\EmailGroupTitle;
use App\Models\Contact_x_Building;
use App\Models\Phone;
use App\Models\Organization;
use App\Models\Building;

use Illuminate\Http\RedirectResponse;


class OrgContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('org_contacts.index')->with('orgs', Organization::orderBy('org_name')->get()->where('client_status', 'A'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('org_contacts.create')->with('email_groups', EmailGroupTitle::orderBy('email_group_title')->get())
				->with('buildings', Building::orderBy('bldg_name')->get());
    }
	
	

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   
    public function store(CreateOrgContactRequest $request)
    {
       if(isset($request->firstName)){
    	   OrgContact::create([
    	        'buildings_id'=>$request->bldgSel,
    	        'last_name'=>$request->lastName,
    	        'first_name'=>$request->firstName,
    	        'email'=>$request->email,
    	        'org_job_title'=>$request->jobTitle,
    	        'notes'=>$request->contactNotes,
    	        'stardoc_user_id'=>$request->stardocId,
    	        'email_group_id'=>$request->emailGroupSel,
    	        'created_date'=>NOW(),
    			'created_by'=>1271,
    			'modified_date'=>NOW(),
    			'modified_by'=>1271
    	    ]);
    	    
    	    $new_contact_id = DB::getPdo()->lastInsertId();
    	    
    	    /*If a building was selected, insert a record into the contacts_x_buildings for the new contact*/
    		if(isset($request->bldgSel)){
        		Contact_x_Building::create([
        		    'contact_type'=>'bldg_contact',
        			'contacts_id'=>$new_contact_id,
        			'buildings_id'=>$request->bldgSel,
        			'created_date'=>NOW(),
        			'created_by'=>1271,
        			'modified_date'=>NOW(),
        			'modified_by'=>1271
    		]);
		}
       }
       
		session()->flash('success', 'New org contact record successfully created');
		
		return redirect(route('org_contacts.index'));
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
			->select('bldg.bldg_id', 'bldg.bldg_name', 'bldg.organizations_id')
			->where('bldg.organizations_id', '=', DB::raw($id));
			
			
		/*Create the subquery for addresses*/
		$addresses = DB::table('addresses AS addr')
			->select('addr.owner_id', 'addr.address', 'addr.address2', 'addr.city', 'addr.state',
				'addr.zip_code', 'addr.county')
			->where('addr.owner_type', '=', 'P')
			->where('addr.address_type', '=', 'L');
			
		
		/*Create the subquery for addressesMail for Mailing (po box) addresses*/
		$addressesMail = DB::table('addresses AS addrM')
			->select('addrM.owner_id AS owner_id_mail', 'addrM.address AS address_mail', 'addrM.address2 AS address2_mail', 'addrM.city AS city_mail',
			    'addrM.state AS state_mail', 'addrM.zip_code AS zip_code_mail', 'addrM.county AS county_mail')
			->where('addrM.owner_type', '=', 'P')
			->where('addrM.address_type', '=', 'M');
			
		/*Create the subquery for main phones*/
		$phones = DB::table('phones AS ph')
        	->select('ph.owner_id', 'ph.area_code', 'ph.exch', 'ph.phone_line')
        	->where('ph.owner_type', '=', 'P')
        	->where('ph.phone_type', '=', 'M');
        	
        /*Create the subquery for mobile*/		
        $mobile = DB::table('phones AS mobile')			
        	->select('mobile.owner_id', 'mobile.area_code AS m_area_code', 'mobile.exch AS m_exch', 'mobile.phone_line AS m_phone_line')			
        	->where('mobile.owner_type', '=', 'P')
        	->where('mobile.phone_type', '=', 'C');
        	
        /*Create the subquery for faxes*/		
        $faxes = DB::table('phones AS fax')			
        	->select('fax.owner_id', 'fax.area_code AS f_area_code', 'fax.exch AS f_exch', 'fax.phone_line AS f_phone_line')			
        	->where('fax.owner_type', '=', 'P')
        	->where('fax.phone_type', '=', 'F');
			
        
        $contact_data = DB::table('organizations')
                ->joinSub($buildings, 'bldg', function($join) use ($id){
				    $join->on('bldg.organizations_id', '=', 'organizations.org_id')
				    
				    ->select('buildings.*', 'organizations.org_name')
					->where('organizations_id', '=', DB::raw($id));
			    })
				->join('contacts', function ($join) use ($id){
								$join->on('contacts.buildings_id', '=', 'bldg.bldg_id')
								->select('contacts.*', 'bldg.bldg_name')
								->where('bldg.organizations_id', '=', DB::raw($id));
				})
				->leftJoinSub($addresses, 'addr', function($join){
    				$join->on('contacts.contact_id', '=', 'addr.owner_id');
    			})
			
    			->leftJoinSub($addressesMail, 'addrM', function($join){
    				$join->on('contacts.contact_id', '=', 'addrM.owner_id_mail');
    			})
    			
    			->leftJoinSub($phones, 'ph', function($join){
    				$join->on('contacts.contact_id', '=', 'ph.owner_id');
    			})
    			
    			->leftJoinSub($mobile, 'mobile', function($join){
			        $join->on('contacts.contact_id', '=', 'mobile.owner_id');
			     })
    			
    			->leftJoinSub($faxes, 'fax', function($join){
			        $join->on('contacts.contact_id', '=', 'fax.owner_id');
			     })
				
				->where('contacts.deleted_at', NULL)				
				->get();
				
		return view('org_contacts.index', compact('contact_data', 'id'))
			->with('orgs', Organization::orderBy('org_name')->get()->where('client_status', 'A'));			
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(OrgContact $org_contact)
    {
        return view('org_contacts.create')->with('org_contact', $org_contact)
			->with('orgs', Organization::orderBy('org_name')->get()->where('client_status', 'A'))
			->with('buildings', Building::orderBy('bldg_name')->get());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateOrgContactRequest $request, OrgContact $orgContact)
    {
        $orgContact->update([
			'organizations_id' => $request->get('org'),
			'first_name' => $request->first_name,
			'last_name' => $request->last_name,
			'user_name' => $request->user_name,
			'password' => $request->pword,
			'position' => $request->position,
			'buildings_id' => $request->get('bldg_id'),
			'email' => $request->email,
			'toner_alert' => $request->get('toner_alert'),
			'service_alert' => $request->get('service_alert'),
			'audit_reports' => $request->get('audit_reports'),			
			/*'created_date' => NOW(),
			'created_by' => 1271,*/
			'modified_date' => NOW(),
			'modified_by' => 1271
		]);
		
		$orgContact->save();
		
		session()->flash('success', 'Contact record was successfully updated');
		
		return redirect(route('org_contacts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($contact_id)
    {
        /* To cascade the deletes so no orphan data is left when a parent org_contact is deleted - -
            When deleting an org_contact, delete the addresses and phones from their respective tables as well.
            To soft delete, use the update method. SoftDelete does not work with DB::raw.*/
        
        DB::update('update addresses set deleted_at = ? where owner_type = ? AND address_type = ? AND owner_id = ?', [now(), 'P', 'L',  $contact_id]);
        DB::update('update addresses set deleted_at = ? where owner_type = ? AND address_type = ? AND owner_id = ?', [now(), 'P', 'M',  $contact_id]);
        DB::update('update phones set deleted_at = ? where phone_type = ? AND owner_type = ? AND owner_id = ?', [now(), 'M', 'P', $contact_id]);
        DB::update('update phones set deleted_at = ? where phone_type = ? AND owner_type = ? AND owner_id = ?', [now(), 'C', 'P', $contact_id]);
        DB::update('update phones set deleted_at = ? where phone_type = ? AND owner_type = ? AND owner_id = ?', [now(), 'F', 'P', $contact_id]);
        
        DB::update('update contacts set deleted_at = ? where contact_id = ?', [now(), $contact_id]);
        
        //OrgContact::destroy($contact_id);
        
        //DB::delete('DELETE FROM contacts WHERE contact_id = ?', [$contact_id]);
		
		session()->flash('success', 'Org Contact record successfully deleted');		
		
		//return view('org_contacts/index')->with('orgs', Organization::orderBy('org_name')->get()->where('client_status', 'A'));
		return redirect()->route('org_contacts.index');
		//return redirect(route('org_contacts.index'));
		
    }
}
