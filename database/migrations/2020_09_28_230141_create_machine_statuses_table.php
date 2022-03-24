<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachineStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machine_statuses', function (Blueprint $table) {            
            $table->bigIncrements('status_id');
            $table->string('serial_number', 25);
			$table->integer('floorplan_machines_id')->nullable();
			$table->char('toner', 1)->nullable()->comment('Is toner needed for this device? Y=Yes N=No');			
			$table->char('service_needed', 1)->nullable()->comment('Is service needed for this device? Y=Yes N=No');			
			$table->dateTime('created_date')->useCurrent();
			$table->integer('created_by');
			$table->dateTime('modified_date')->useCurrent();
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
        Schema::dropIfExists('machine_statuses');
    }
}
