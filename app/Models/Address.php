<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Organization;
use App\Models\Building;
use App\Models\OrgContact;

class Address extends Model
{
    protected $primaryKey = 'addr_id';
	//use HasFactory;
	use SoftDeletes;
	
	protected $fillable = ['address_type', 'owner_type', 'owner_id', 'address', 'address2',
        'city', 'state', 'zip_code', 'county', 'created_date', 'created_by', 'modified_date', 'modified_by', 'deleted_at'];
        
    /*This is required if not using the default timestamps, because CRUD will look for these columns.*/
	public $timestamps = false;
    
public function organizations(){
		return $this->belongsTo(Organization::class);
	}
	
/*Each address belongs to only 1 building*/
public function buildings(){
		return $this->belongsTo(Building::class);
	}

}

