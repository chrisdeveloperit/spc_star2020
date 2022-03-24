<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Floorplan;


class FloorplanMachine extends Model
{
    //use HasFactory;
    protected $primaryKey = 'fpm_id';
    
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'modified_date';
    
    use SoftDeletes;
    
    protected $fillable = ['deleted_at'];
    
    public function floorplans(){
		return $this->belongsTo(Floorplan::class);
	}
	

    /*This is required if not using the default timestamps, because CRUD will look for these columns.*/
	public $timestamps = false;
}
