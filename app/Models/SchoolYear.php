<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Machine_Archive;

class SchoolYear extends Model
{
    
    protected $table = 'school_years';
	protected $primaryKey = 'year_id';
	
	use SoftDeletes;

	public function organizations(){
		return $this->hasMany(Machine_Archive::class);
	}
	
	/*This is required if not using the default timestamps, because CRUD will look for these columns.*/
	public $timestamps = false;
}
