<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use App\Models\Floorplan_2019;

class FloorplanMachines_2019 extends Model
{
	use HasFactory;

    /*alias the table name since it doesn't follow Laravel standards*/
	protected $table = 'Y2019_floorplan_machines';
	
	public function floorplans_2019(){
		return $this->belongsTo(Floorplan_2019::class);
	}
}
