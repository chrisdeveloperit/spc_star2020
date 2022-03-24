<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Organization;
use App\Models\Floorplan;
use App\Models\OrgContact;
use App\Models\Building;
use App\Models\SpcUser;


class Building extends Model
{

	protected $primaryKey = 'bldg_id';
	
	const CREATED_AT = 'created_date';
    const UPDATED_AT = 'modified_date';
	
	use SoftDeletes;
	
	//use HasFactory;
    protected $fillable = ['organizations_id', 'bldg_name', 'bldg_name_short', 'bldg_contact', 'student_pop',
        'bldg_equip_cost', 'notes', 'created_date','created_by', 'modified_date', 'modified_by', 'deleted_at'];
	
	/*This is required if not using the default timestamps, because CRUD will look for these columns.*/
	public $timestamps = false;
	
	
	public function organizations(){
		return $this->belongsTo(Organization::class);
	}
	
	/*There  will be 1 floorplan for a building for each floor*/
	public function floorplans(){
		return $this->hasMany(Floorplan::class);
	}
	
	public function phones(){
		return $this->hasMany(Phone::class);
	}
	
	public function orgContacts(){
		return $this->hasMany(OrgContact::class);
	}
	
	public function spc_users(){
		return $this->hasMany(SpcUser::class);
	}
}


