<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateY2019FloorplanMachinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('y2019_floorplan_machines', function (Blueprint $table) {
        	$table->bigIncrements('id');
    		$table->integer('fm_audit_id')->nullable();
    		$table->integer('machines_id')->nullable()->comment('FK machines.machines_id for Proposed Machines');
			$table->integer('present_machines_id')->nullable()->comment('FK machines.machines_id for machines currently being used');
    		$table->integer('x_position')->nullable()->comment('Proposed x position of device on the floorplan');
    		$table->integer('y_position')->nullable()->comment('Proposed y position of device on the floorpln');
    		$table->integer('floorplans_id')->nullable()->comment('FK to the floorplans table.');
    		$table->integer('departments_id')->nullable()->comment('FK to the departments table.');
    		$table->string('room_name', 50)->nullable()->comment('Was room_number in old table. Current room number or name');
    		$table->string('serial_number', 25)->nullable()->comment('Proposed serial_number');
    		$table->string('mac_address', 50)->nullable()->comment('Mac address from FM Audit.');
    		$table->string('ip_address', 50)->nullable()->comment('Was IP_Address in old table. Comes from FM Audit.');
    		$table->string('present_vendor_mach_id', 50)->nullable()->comment('Was vendor_device_id in old table. The id that the vendor generates for a specific machine.');
    		$table->string('proposed_vendor_mach_id', 50)->nullable()->comment('Was new_vendor_device_id in old table. The id that the vendor generates for a specific machine.');
    		$table->integer('budgeted_black')->nullable()->comment('Budgeted black volume');
			$table->integer('budgeted_color')->nullable()->comment('Budgeted color volume');
			$table->decimal('cpc_black', 7, 6)->nullable()->comment('cost per copy black');
			$table->decimal('cpc_color', 7, 6)->nullable()->comment('cost per copy color');
    		$table->integer('five_year_id')->nullable();
			$table->integer('proposed_type_id')->nullable()->comment('Proposed machine type. orig type_id - Kept for now, but may not need');
			$table->integer('present_type_id')->nullable()->comment('Present machine type. Kept for now, but may not need');
    		$table->char('is_proposed', 1)->nullable()->comment('Y=yes, N=no, U=??');
			$table->char('under_contract', 1)->nullable()->comment('Is the device under contract with SPC. Y=yes, N=no, U=??');
			$table->dateTime('commencement_date')->nullable()->comment('Date device came on line.');
			$table->integer('commencement_black_meter')->nullable();
			$table->integer('commencement_color_meter')->nullable();
			$table->dateTime('closeout_date')->nullable();
    		$table->integer('present_floorplan_id')->nullable()->comment('FK Floorplan table where machine is currently located');
			$table->integer('present_x_position')->nullable()->comment('Current x position on floorplan map.');
			$table->integer('present_y_position')->nullable()->comment('Current y position on floorplan map.');
			$table->string('present_serial_number', 25)->nullable()->comment('Current serial_number');
    		$table->integer('fyer_group_id')->nullable()->comment('FK to fyer_group table. Col old name was save_name_id');    
    		$table->dateTime('created_date');
			$table->integer('created_by');
			$table->dateTime('modified_date');
			$table->integer('modified_by');
        	$table->dateTime('deleted_date')->nullable();
        	
        	$table->index('serial_number', 'idx_serNum'); #add index
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('y2019_floorplan_machines');
    }
}
