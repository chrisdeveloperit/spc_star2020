<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class FyerGroup extends Model
{
    
    protected $primaryKey = 'fyer_grp_id';
    use HasFactory;
    use SoftDeletes;
    
    /*This is required if not using the default timestamps, because CRUD will look for these columns.*/
	public $timestamps = false;	
}
