<?php

/*the people table belongs to OrgContacts Model*/

/*namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

	use App\Models\Organization;

class People extends Model
{
    use HasFactory;

	protected $fillable = [
        'first_name', 'last_name', 'organizations_id', 'buildings_id', 'position', 'user_name', 'password',
		'user_level', 'org_user_level', 'email', 'primary_user', 'primary_contact', 'active',
		'toner_alert', 'service_alert', 'audit_reports', 'change_password_on_login', 'hover_enabled',
		'security_profile', 'test_user', 'admin_photo_url', 'created_date', 'created_by',
		'modified_date', 'modified_by'
    ];
	
	public function phones(){
		return $this->hasMany(Phone::class);	
	}
	
	public function organizations(){
		return $this->belongsTo(Organization::class);
	}
}*/
