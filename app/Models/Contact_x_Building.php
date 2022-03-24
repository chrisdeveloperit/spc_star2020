<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Building;
use App\Models\OrgContact;


class Contact_x_Building extends Model
{
    //use HasFactory;
    use SoftDeletes;
    
    protected $table = 'contacts_x_buildings';
    
     protected $fillable = [
        'contact_type', 'contacts_id', 'buildings_id', 'created_date', 'created_by', 'modified_date', 'modified_by', 'deleted_at'
    ];
    
    
    public function organizations(){
		return $this->hasMany(Organization::class);
	}
	
	public function buildings(){
		return $this->hasMany(Building::class);
	}
    
    
    /*This is required if not using the default timestamps, because CRUD will look for these columns.*/
	public $timestamps = false;
}
