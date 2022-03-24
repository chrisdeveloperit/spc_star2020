<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('contact_id');
            $table->integer('buildings_id')->nullable()->comment('Foreign key to the buildings table.');
            $table->string('last_name', 25)->nullable();
            $table->string('first_name', 25)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('org_job_title', 50)->nullable()->comment('Org title as assigned by org, NOT an SPC defined title.');
            $table->text('notes')->nullable();
            $table->integer('stardoc_user_id')->nullable();
            $table->integer('email_group_id')->nullable()->comment('id for the SPC defined title used for sending group emails.');
            $table->timestamp('created_date')->useCurrent()->comment('Date and time contact was created.');
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
        Schema::dropIfExists('contacts');
    }
}
