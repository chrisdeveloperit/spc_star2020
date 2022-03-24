<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Building;
use App\Models\FloorplanMachines;

class Floorplan extends Model
{
	protected $primaryKey = 'fp_id';
	
	//use HasFactory;
	use SoftDeletes;
	
	/*This is required if not using the default timestamps, because CRUD will look for these columns.*/
	public $timestamps = false;

	public function buildings(){
		return $this->belongsTo(Building::class);
	}
	
	public function floorplan_machines(){
		return $this->hasMany(FloorplanMachines::class);
	}
}
