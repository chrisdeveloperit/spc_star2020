<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachineArchiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('machine_archive')) {
            Schema::create('machine_archive', function (Blueprint $table) {
                $table->bigIncrements('arch_device_id');
                $table->string('serial_number', 25)->comment('Was SerialNumber in old table.');
                $table->integer('organizations_id');
                $table->integer('buildings_id');
                $table->integer('departments_id')->nullable();
                $table->string('room_name', 50)->nullable();
                $table->integer('school_year')->nullable();
                $table->integer('vendor_id')->nullable()->comment('FK to org_id in the organization table');
                $table->string('vendor_mach_id', 25)->nullable();
                $table->integer('machine_specs_id')->nullable()->comment('FK machine_specs.spec_id. Was model_id in old table.');
                $table->text('features_list')->nullable()->comment('Was Features in old table. Used to list the array of features for this machine.');

                $table->char('mach_condition', 1)->nullable()->comment('Was Condition in old table. N=New, R=Reconditioned');
                $table->date('install_date')->nullable()->comment('Was Install in old table.');
                $table->integer('projected_volume_black')->nullable()->comment('Was Anticipated in old table.');
                $table->integer('projected_volume_color')->nullable()->comment('Was ProjColorVol in old table.');
                $table->decimal('cpc_black', 7, 6)->nullable()->comment('Was CostCopy in old table.');
                $table->decimal('new_cpc_black', 7, 6)->nullable()->comment('Was NewCostCopy in old table.');
                $table->decimal('cpc_color', 7, 6)->nullable()->comment('Was Mstrcpc in old table.');
                $table->decimal('new_cpc_color', 7, 6)->nullable()->comment('Was NewColorCPC in old table.');
                $table->date('meter_begin_date')->nullable()->comment('Was BDate in old table.');
                $table->date('meter_end_date')->nullable()->comment('Was EDate in old table.');
                $table->integer('meter_begin_read_black')->nullable()->comment('Was Begin in old table.');
                $table->integer('meter_end_read_black')->nullable()->comment('Was End in old table.');
                $table->integer('meter_begin_read_color')->nullable()->comment('Was MstrBegin in old table.');
                $table->integer('meter_end_read_color')->nullable()->comment('Was MstrEnd in old table.');

                $table->text('device_comments')->nullable()->comment('Was Comments in old table.');
                $table->char('lease_own', 1)->nullable()->comment('Was lease in old table. Type of Possession. L=Leased, O=Owned, R=Rental, B=Loaner(Borrowed)');
                $table->decimal('cpc_black_vendor', 7, 6)->nullable()->comment('Was Black_Vendor_cpc in old table.');
                $table->decimal('cpc_color_vendor', 7, 6)->nullable()->comment('Was Color_Vendor_cpc in old table.');
                $table->decimal('new_cpc_black_vendor', 7, 6)->nullable()->comment('Was New_Blk_Ven_cpc in old table.');
                $table->decimal('new_cpc_color_vendor', 7, 6)->nullable()->comment('Was New_Color_Ven_cpc in old table.');
                $table->string('replacement_for', 25)->nullable()->comment('Was txtReplacedMachine in old table.');
                $table->dateTime('last_meter_import')->nullable()->comment('New column, was not in old table.');
                $table->timestamp('created_date')->useCurrent();
                $table->integer('created_by');
                $table->timestamp('modified_date')->useCurrent();
                $table->integer('modified_by');
                $table->dateTime('deleted_at')->nullable();

                $table->index('serial_number', 'idx_serNum');
                $table->index(['serial_number', 'created_date'], 'idx_serNum_date');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('machine_archive');
    }
}
