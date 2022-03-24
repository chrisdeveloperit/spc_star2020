<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\OrgContact;

class EmailGroupTitle extends Model
{
    protected $primaryKey = 'email_grp_id';
    
    //use HasFactory;
    use SoftDeletes;
    
    public function contacts(){
		return $this->hasMany(OrgContact::class);
	}
    
    
    /*This is required if not using the default timestamps, because CRUD will look for these columns.*/
	public $timestamps = false;
}
