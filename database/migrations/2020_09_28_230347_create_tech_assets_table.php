<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tech_assets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('org_id');
        	$table->dateTime('created_date');
			$table->integer('created_by');
			$table->dateTime('modified_date');
			$table->integer('modified_by');
        	$table->dateTime('deleted_date')->nullable();
			/*$table->integer('bldg_id');
			$table->integer('dept_id')->nullable();
			$table->integer('room_id')->nullable();
			$table->integer('school_year')->nullable();
			$table->integer('vendor_id')->nullable();
			$table->string('vendor_mach_id', 25)->nullable();
			$table->integer('model_id')->nullable();
			$table->text('features_list')->nullable();
			$table->string('serial_number', 25);
			$table->char('mach_condition', 1)->nullable()->comment('N=New, R=Reconditioned');
			$table->date('install_date')->nullable();*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tech_assets');
    }
}
