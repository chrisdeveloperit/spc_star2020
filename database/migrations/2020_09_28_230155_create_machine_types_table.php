<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachineTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machine_types', function (Blueprint $table) {            
            $table->bigIncrements('mach_type_id');
            $table->string('type_name');
			$table->string('machine_type', 25)->nullable();
			$table->string('icon_type', 30)->nullable()->comment('Type of image for devices on the floorplan.');			
			$table->char('is_color', 1)->nullable()->comment('Is this a color device? Y=Yes N=No');
			$table->char('covered', 1)->nullable()->comment('Is this device covered by SPC? Y=Yes N=No');
			$table->decimal('black_cpc_markup', 11, 2)->nullable();
			$table->decimal('color_cpc_markup', 11, 2)->nullable();
			$table->char('printer_copier', 1)->nullable()->comment('Is this device a printer or copier?? P=Printer C=Copier');
			$table->timestamp('created_date')->useCurrent();
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
        Schema::dropIfExists('machine_types');
    }
}
