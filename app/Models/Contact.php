<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Building;
use App\Models\Phone;
use App\Models\Address;
use App\Models\Email_Group_Title;

class Contact extends Model
{
    protected $primaryKey = 'contact_id';
    
    //use HasFactory;
    use SoftDeletes;
    
    public function addresses(){
		return $this->hasMany(Address::class);
    }
	
	public function phones(){
		return $this->hasMany(Phone::class);
	}
	
	/*This contact is a child record of email_group_titles*/ 
	public function email_group_titles(){
		return $this->belongsTo(Email_Group_Title::class);
	}
    
    
    /*This is required if not using the default timestamps, because CRUD will look for these columns.*/
	public $timestamps = false;
}
