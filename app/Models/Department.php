<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Department;
use App\Models\Organization;

class Department extends Model
{
    
    protected $primaryKey = 'dept_id';
    //use HasFactory;
    use SoftDeletes;
    
    protected $fillable = ['organizations_id', 'dept_name'];
    
    /*This is required if not using the default timestamps, because CRUD will look for these columns.*/
	public $timestamps = false;
	
	
	public function organizations(){
		return $this->belongsTo(Organization::class);
	}
}
