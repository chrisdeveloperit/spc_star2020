<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblWhatIf extends Model
{
    //use HasFactory;
	/*This is required if not using the default timestamps, because CRUD will look for these columns.*/
	public $timestamps = false;	
}
