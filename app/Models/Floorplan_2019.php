<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use App\Models\Floorplan_2019;
use App\Models\FloorplanMachines_2019;


class Floorplan_2019 extends Model
{

	//use HasFactory;
    /*public function buildings_2019(){
		return $this->belongsTo(Building_2019::class);
	}*/
	
	public function floorplan_machines_2019(){
		return $this->hasMany(FloorplanMachines_2019::class);
	}
}