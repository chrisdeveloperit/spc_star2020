<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Y2019MachineStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('y2019_machine_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('serial_number', 30);
			$table->integer('machine_id')->nullable();
			$table->char('toner', 1)->nullable()->comment('Is toner needed for this device? Y=Yes N=No');			
			$table->char('service_needed', 1)->nullable()->comment('Is service needed for this device? Y=Yes N=No');			
			$table->dateTime('created_date');
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
        //
    }
}
