<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MachineType extends Model
{
   protected $primaryKey = 'mach_type_id';
   
    //use HasFactory;
    use SoftDeletes;

	protected $fillable = [
		'type_name',
		'machine_type',
		'icon_type',
		'is_color',
		'covered',
		'created_date',
		'created_by',
		'modified_date',
		'modified_by'
	];
	
	/*This is required if not using the default timestamps, because CRUD will look for these columns.*/
	public $timestamps = false;
}
