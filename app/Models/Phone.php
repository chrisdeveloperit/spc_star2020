<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Organization;
use App\Models\Building;
use App\Models\People;

class Phone extends Model
{
    protected $primaryKey = 'ph_id';
    
    
    //use HasFactory;
    use SoftDeletes;

	protected $fillable = [
        'phone_type', 'owner_type', 'owner_id', 'area_code', 'exch', 'phone_line', 'extension',
		'created_date', 'created_by', 'modified_date', 'modified_by'
    ];
    
     /*This is required if not using the default timestamps, because CRUD will look for these columns.*/
	public $timestamps = false;
	
	public function users(){
		return $this->belongsToMany(People::class);
	}
	
	public function organizations(){
		return $this->belongsToMany(Organization::class);
	}
	
	/*Each phone belongs to only 1 building*/
	public function buildings(){
		return $this->belongsTo(Building::class);
	}
}
