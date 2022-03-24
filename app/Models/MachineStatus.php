<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MachineStatus extends Model
{
	protected $primaryKey = 'status_id';
	
	//use HasFactory;
	use SoftDeletes;

	protected $fillable = [
		'serial_number',
		'machine_id',
		'toner',			
		'service_needed',
		'created_date',
		'created_by',
		'modified_date',
		'modified_by'
	];
	
	/*This is required if not using the default timestamps, because CRUD will look for these columns.*/
	public $timestamps = false;
	
	public function current_devices(){
		return $this->belongsTo(CurrentDevice::class);
	}
}