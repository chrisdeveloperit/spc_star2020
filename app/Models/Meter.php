<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meter extends Model
{
    protected $primaryKey = 'mtr_id';
    
    //use HasFactory;
    use SoftDeletes;

	protected $fillable = [
		'serial_number',
		'black_meter',
		'color_meter',
		'created_date',
		'created_by',
		'modified_date',
		'modified_by'
	];
	
	
	/*This is required if not using the default timestamps, because CRUD will look for these columns.*/
	public $timestamps = false;
}
