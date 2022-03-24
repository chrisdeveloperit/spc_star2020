<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meters', function (Blueprint $table) {
            $table->bigIncrements('mtr_id');
			$table->string('serial_number')->nullable()->comment('FKey to the current_devices table. Device serial number');
			//$table->integer('device_id')->comment('FKey to the current_devices table');
			$table->integer('black_meter')->comment('Device meter read for black volume');
			$table->integer('color_meter')->nullable()->comment('Device meter read for color volume');
			$table->timestamp('created_date')->useCurrent()->comment('Date and time meter was read.');
			$table->integer('created_by');
			$table->timestamp('modified_date')->useCurrent();
			$table->integer('modified_by');
        	$table->dateTime('deleted_at')->nullable();
        
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
        Schema::dropIfExists('meters');
    }
}
