<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class CurrentDevice extends Model
{
    protected $primaryKey = 'device_id';
    
    //use HasFactory;
    use SoftDeletes;
    

    protected $fillable = [
		'organizations_id',
		'buildings',
		
		'created_date',
		'created_by',
		'modified_date',
		'modified_by'
	];
	
	/*This is required if not using the default timestamps, because CRUD will look for these columns.*/
	public $timestamps = false;	
		
	public function machine_statuses(){
		return $this->hasMany(MachineStatus::class);
	}
	
}