<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\SpcUser;
use App\Models\Building;
use App\Models\Organization;


class SpcUser extends Model
{
    protected $table = 'spc_users';
    protected $primaryKey = 'peo_id';
    //use HasFactory;
    use SoftDeletes;
    
    public function buildings(){
		return $this->belongsTo(Building::class);
	}
	
	/*public function buildings(){
		return $this->hasMany(Building::class);
	}*/
	
	public function organizations(){
		return $this->belongsTo(Organization::class);
	}
	
	
	/*This is required if not using the default timestamps, because CRUD will look for these columns.*/
	public $timestamps = false;
}
