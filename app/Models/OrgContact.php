<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Organization;
use App\Models\Building;
use App\Models\Address;
use App\Models\Phone;
use App\Models\OrgContact;
use App\Models\Contact_x_Building;

//use DB;
use Illuminate\Support\Facades\DB;

class OrgContact extends Model
{
    //use HasFactory;
    use SoftDeletes;

	protected $table = 'contacts';
	protected $primaryKey = 'contact_id';
	
	const CREATED_AT = 'created_date';
    const UPDATED_AT = 'modified_date';
	
	/*This is required if not using the default timestamps, because CRUD will look for these columns.*/
	public $timestamps = false;
	
    protected $fillable = [
        'buildings_id', 'last_name', 'first_name', 'email', 'org_job_title', 'notes', 'stardoc_user_id',
        'email_group_id', 'created_date', 'created_by', 'modified_date', 'modified_by', 'deleted_at'
    ];
	
	public function addresses(){
		return $this->hasMany(Address::class);	
	}
	
	public function phones(){
		return $this->hasMany(Phone::class);	
	}
	
	public function organizations(){
		return $this->belongsTo(Organization::class);
	}
	
	public function buildings(){
		return $this->belongsTo(Building::class);
	}
}
