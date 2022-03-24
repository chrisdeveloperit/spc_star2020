<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsXBuildingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts_x_buildings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('contact_type', 25)->comment = 'Type of contact bldg_contact(from buildings) decision_maker (from tblContacts)';
            $table->integer('contacts_id')->nullable()->comment('Foreign key to the contacts table.');
            $table->integer('buildings_id')->nullable()->comment('Foreign key to the buildings table.');
            $table->timestamp('created_date')->useCurrent()->comment('Date and time record was created.');
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
        Schema::dropIfExists('contacts_x_buildings');
    }
}
