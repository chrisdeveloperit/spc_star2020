<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrentDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('current_devices', function (Blueprint $table) {
            
            $table->bigIncrements('device_id');
            $table->string('serial_number', 25)->comment('Was SerialNumber in old table.');
            $table->integer('organizations_id');
			$table->integer('buildings_id');
			$table->integer('departments_id')->nullable();
			$table->string('room_name', 50)->nullable();
			$table->integer('school_year')->nullable();
			$table->integer('vendor_id')->nullable();
			$table->string('vendor_mach_id', 25)->nullable();
			$table->integer('machine_specs_id')->nullable()->comment('FK machine_specs.spec_id. Was model_id in old table.');
			$table->text('features_list')->nullable()->comment('Was Features in old table. Used to list the array of features for this machine.');
			
			$table->char('mach_condition', 1)->nullable()->comment('N=New, R=Reconditioned');
			$table->date('install_date')->nullable();
			$table->integer('projected_volume_black')->nullable();
			$table->integer('projected_volume_color')->nullable();
			$table->decimal('cpc_black', 7, 6)->nullable();
			$table->decimal('new_cpc_black', 7, 6)->nullable();
			$table->decimal('cpc_color', 7, 6)->nullable();
			$table->decimal('new_cpc_color', 7, 6)->nullable();
			$table->date('meter_begin_date')->nullable();
			$table->date('meter_end_date')->nullable();
			$table->integer('meter_begin_read_black')->nullable();
			$table->integer('meter_end_read_black')->nullable();
			$table->integer('meter_begin_read_color')->nullable();
			$table->integer('meter_end_read_color')->nullable();
			
			$table->text('device_comments')->nullable();
			$table->char('lease_own', 1)->nullable()->comment('Type of Possession. L=Leased, O=Owned, R=Rental, B=Loaner(Borrowed)');
			$table->decimal('cpc_black_vendor', 7, 6)->nullable();
			$table->decimal('cpc_color_vendor', 7, 6)->nullable();
			$table->decimal('new_cpc_black_vendor', 7, 6)->nullable();
			$table->decimal('new_cpc_color_vendor', 7, 6)->nullable();
			$table->string('replacement_for', 25)->nullable();
			$table->timestamp('created_date')->useCurrent();
			$table->integer('created_by');
			$table->timestamp('modified_date')->useCurrent();
			$table->integer('modified_by');
        	$table->dateTime('deleted_at')->nullable();
        	
        	$table->index('serial_number', 'idx_serNum');
        	$table->index(['serial_number', 'buildings_id'], 'idx_serNum_bldg');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('current_devices');
    }
}
