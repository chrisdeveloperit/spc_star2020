<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateY2019Meters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('y2019_meters', function (Blueprint $table) {
            //$table->id();
            $table->bigIncrements('id');
			$table->string('serial_number')->nullable()->comment('FKey to the current_devices table. Device serial number');
			$table->integer('machine_id')->nullable()->comment('We may drop this col. FKey to the current_devices table');
			$table->integer('black_meter')->comment('Device meter read for black volume');
			$table->integer('color_meter')->nullable()->comment('Device meter read for color volume');
			$table->dateTime('created_date')->comment('Date and time meter was read.');
			$table->integer('created_by');
			$table->dateTime('modified_date');
			$table->integer('modified_by');
        	$table->dateTime('deleted_date')->nullable();
        
        	$table->index('serial_number', 'idx_serNum');
        	$table->index(['serial_number', 'created_date'], 'idx_serNum_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('y2019_meters');
    }
}
