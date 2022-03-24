<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MachineSpec extends Model
{
   
    protected $primaryKey = 'spec_id';
    
    //use HasFactory;
    use SoftDeletes;
    
    protected $fillable = ['mach_make',
        'model',
        'features',
        'min_speed',
		'max_speed',
		'machine_image',
		'intro',
		'life',
		'is_color',
        'created_date',
		'created_by',
		'modified_date',
		'modified_by'];
    
    /*This is required if not using the default timestamps, because CRUD will look for these columns.*/
	public $timestamps = false;	
    
}
