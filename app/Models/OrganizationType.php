<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Organization;

class OrganizationType extends Model
{
    protected $primaryKey = 'org_type_id';
    //use HasFactory;
    use SoftDeletes;
    
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'modified_date';

	protected $fillable = ['org_type_name'];
	
	
	/*This is required if not using the default timestamps, because CRUD will look for these columns.*/
	public $timestamps = false;
	
	public function organization_types(){
		return $this->hasMany(Organization::class);
	}
}
