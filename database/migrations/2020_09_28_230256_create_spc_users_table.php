<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpcUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*This was renamed to people from users in the old db because the default Laravel users table is for login purposes only.*/
        Schema::create('spc_users', function (Blueprint $table) {
            $table->increments('peo_id', 11);			
			$table->string('first_name', 26);
			$table->string('last_name', 25);
			$table->integer('organizations_id');
			$table->integer('buildings_id')->nullable();
			$table->string('position', 30)->nullable()->comment = 'The position, as given by the user.';
			$table->string('user_name', 50);
			/*$table->string('password', 100);
			$table->integer('user_level')->comment = 'The level of access allowed for this user';
			$table->integer('org_user_level')->comment = 'The level of access allowed for this user';*/
			$table->string('email', 100)->nullable();
			//$table->string('email', 100)->unique()->nullable();
			/*$table->char('primary_user', 1)->nullable()->comment = 'Y = yes, N = no';
			$table->char('primary_contact', 1)->nullable()->comment = 'Y = yes, N = no';
			$table->char('active', 1)->default('Y') ->comment = 'Y = yes, N = no';*/
			$table->char('toner_alert', 1)->default('N') ->comment = 'Y = yes, N = no';
			$table->char('service_alert', 1)->default('N') ->comment = 'Y = yes, N = no';
			$table->char('audit_reports', 1)->default('N') ->comment = 'Y = yes, N = no';
			//$table->char('change_password_on_login', 1)->default('N') ->comment = 'Y = yes, N = no';
			$table->char('hover_enabled', 1)->nullable()->comment = 'Y = yes, N = no';
			$table->text('security_profile')->nullable();
			/*$table->char('test_user', 1)->default('N') ->comment = 'Y = yes, N = no';
			$table->string('admin_photo_url', 100)->nullable()->comment = 'the url of where the admin photo is stored';*/
			$table->timestamp('created_date')->useCurrent();
			$table->integer('created_by');
			$table->timestamp('modified_date')->useCurrent();
			$table->integer('modified_by');
        	$table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spc_users');
    }
}
