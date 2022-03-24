<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SchoolYears;
use Illuminate\Database\Eloquent\SoftDeletes;

class MachineArchive extends Model
{
    protected $primaryKey = 'arch_device_id';
    //use HasFactory;
    use SoftDeletes;

	public function school_years(){
		return $this->belongsTo(SchoolYears::class);
	}

	/*This is required if not using the default timestamps, because CRUD will look for these columns.*/
	public $timestamps = false;
}
