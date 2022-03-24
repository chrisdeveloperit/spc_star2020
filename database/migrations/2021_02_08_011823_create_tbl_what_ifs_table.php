<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblWhatIfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_what_ifs', function (Blueprint $table) {
            $table->bigIncrements('id', 11);
            $table->integer('fyer_group_id')->comment('FK to fyer_group table. Col old name was save_name_id');
        	$table->integer('floorplan_machines_id')->nullable()->comment('FK to floorplan_machines table');
        	$table->integer('report_id')->nullable()->comment('Sequential number for the fyer report. Was ID# in old table');
        	$table->integer('buildings_id')->comment('FK to buildings table.');
        	$table->string('new_serial_number', 25)->nullable()->comment('Proposed device serial_number');
        	$table->string('serial_number', 25)->nullable()->comment('Current device serial_number');
        	$table->string('features_list', 250)->nullable()->comment('List of features');
        	$table->string('speed', 50)->nullable();
        	$table->integer('annual_volume')->nullable();
        	$table->integer('bid_meter')->nullable();
        	$table->date('intro_date')->nullable()->comment('Date machine was introduced.');
        	$table->integer('life')->nullable()->comment('Life of the machine.');
        	$table->string('move_to', 50)->nullable()->comment('Machine move to location.');
        	$table->string('move_from', 50)->nullable()->comment('Machine move from location.');
        	$table->string('first_year_equip', 255)->nullable();
        	$table->integer('proposed_volume_black')->nullable();
        	$table->string('second_year_equip', 50)->nullable();
        	$table->string('third_year_equip', 50)->nullable();
        	$table->string('fourth_year_equip', 50)->nullable();
        	$table->string('fifth_year_equip', 50)->nullable();
        	$table->string('proposed_vendor_mach_id', 50)->nullable()->comment('Was NewVendorID in old table');
        	$table->string('present_vendor_mach_id', 50)->nullable()->comment('Was VendorID in old table');
        	$table->integer('vendor_id')->nullable()->comment('FK to organizations table. Was VendorName in old table');        	
        	$table->decimal('cpc_black', 7, 6)->nullable()->comment('The current black cpc. Was AdjCostCopy in old table');
        	$table->integer('proposed_type_id')->nullable()->comment('Was GroupTag in old table. FK to machine_types table');
        	$table->decimal('proposed_cpc_black', 7, 6)->nullable()->comment('The proposed black cpc. Was PropCost in old table');
        	$table->integer('forced_upgrades')->nullable()->comment('Was ForcedUpgrades in old table');
        	$table->decimal('service_supplies', 10, 4)->nullable()->comment('Was SS&S in old table');
        	
        	$table->date('install_date')->nullable()->comment('Was Install in old table');
        	$table->char('lease_own', 1)->nullable()->comment('Was lease in old table Type of Possession. L=Leased, O=Owned, R=Rental, B=Loaner(Borrowed)');
        	$table->integer('color_volume')->nullable()->comment('Was Color_Vol in old table');
        	$table->decimal('cpc_color', 7, 6)->nullable()->comment('Was Color_CPC in old table');
        	$table->decimal('proposed_cpc_color', 7, 6)->nullable()->comment('Was NewColorCPC in old table');
        	$table->integer('proposed_volume_color')->nullable()->comment('Was ProjColorVol in old table');        
        	$table->string('ip_address', 50)->nullable()->comment('Was IP_Address in old table');
        	$table->string('special_notes', 255)->nullable()->comment('Was Special_Notes in old table');
        	$table->date('proposed_intro_date')->nullable()->comment('Was prop_intro in old table');
        	$table->integer('proposed_life')->nullable()->comment('Was prop_life in old table');
        	$table->string('mac_address', 50)->nullable();
        
        	$table->integer('present_type_id')->nullable()->comment('??FK to machine_types table');
        	$table->integer('present_model_id')->nullable()->comment('??FK to machine_types table');
        	$table->integer('proposed_model_id')->nullable()->comment('??');
        	$table->integer('present_floorplan_id')->nullable()->comment('??');
        	$table->string('present_room_name', 50)->nullable()->comment('Was present_room_number in old table. Room number or name');
        	$table->integer('close_out_black_meter')->nullable()->comment('Device meter read for black volume');
			$table->integer('close_out_color_meter')->nullable()->comment('Device meter read for color volume');
        	$table->integer('commencement_black_meter')->nullable()->comment('Device meter read for black volume');
			$table->integer('commencement_color_meter')->nullable()->comment('Device meter read for color volume');
        	$table->integer('dept_id')->nullable();
        	$table->decimal('vendor_cpc_black_present', 7, 6)->nullable()->comment('Was vendor_black_cpc_present in old table.');
        	$table->decimal('vendor_cpc_color_present', 7, 6)->nullable()->comment('Was vendor_color_cpc_present in old table.');
        	$table->decimal('vendor_cpc_black_proposed', 7, 6)->nullable()->comment('Was vendor_black_cpc_proposed');
        	$table->decimal('vendor_cpc_color_proposed', 7, 6)->nullable()->comment('Was vendor_color_cpc_proposed');
        	$table->decimal('raw_equip_cost', 10, 4)->nullable()->comment('This field is the purchase price of the machine.');
        
        	$table->dateTime('created_date');
			$table->integer('created_by');
			$table->dateTime('modified_date');
			$table->integer('modified_by');
        	$table->dateTime('deleted_date')->nullable();
        	
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
        Schema::dropIfExists('tbl_what_ifs');
    }
}
