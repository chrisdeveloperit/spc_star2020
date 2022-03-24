<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\OrgContact;
use App\Models\OrganizationType;
use App\Models\Building;
use App\Models\Phone;
use App\Models\Address;


class Organization extends Model
{
    protected $primaryKey = 'org_id';
    
    //use HasFactory;
    use SoftDeletes;
    
    protected $fillable = ['org_name', 'org_short_name', 'organization_types_id', 'website', 'fmaudit_client_id',
        'commencement_date', 'client_since', 'client_status', 'print_mgmt_software_installed',
        'lenp_contract_signed',
		'display_meter_data',
		'client_logo',
		'gm_notes',
		'org_message',
		'bank_buyout',
		'spc_service_fee',
		'trade_out_deletion',
		'new_upgrade_date',
		'temp_inactive',
        'created_date',
        'created_by',
        'modified_date',
        'modified_by',
        'deleted_at'];
    

	public function org_contacts(){
		return $this->hasMany(OrgContact::class); //return $this->hasMany(People::class);
	}
	
	public function organization_types(){
		return $this->belongsTo(OrganizationType::class);
	}
	
	public function buildings(){
		return $this->hasMany(Building::class);
	}
	
	public function departments(){
		return $this->hasMany(Department::class);
	}
	
	public function addresses(){
		return $this->hasMany(Address::class);
    }
	
	public function phones(){
		return $this->hasMany(Phone::class);
	}

	

	/*This is required if not using the default timestamps, because CRUD will look for these columns.*/
	public $timestamps = false;
}
