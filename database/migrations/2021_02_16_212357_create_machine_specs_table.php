<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachineSpecsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('machine_specs')) {
            Schema::create('machine_specs', function (Blueprint $table) {
                $table->bigIncrements('spec_id')->comment('The id for this record. This is NOT the model_id.');
                $table->integer('model_id');
                $table->string('mach_make', 40)->nullable();
                $table->string('model', 30)->nullable()->comment('Model name, example: Laser Jet 9000');
                $table->integer('machine_types_id')->nullable()->comment('Was model_type in old table. FK to the machine_types table');
                $table->string('features', 200)->nullable()->comment('Features of this machine');
                $table->string('machine_image', 50)->nullable()->comment('The file name of the image for this machine');
                $table->date('intro')->nullable();
                $table->integer('life')->nullable()->comment('Amount of copies machine is expected to print.????');
                $table->integer('min_speed')->nullable()->comment('The minimum amt of copies per minute that this printer can print.');
                $table->integer('max_speed')->nullable()->comment('The maximum amt of copies per minute that this printer can print.');
                $table->text('meter_read_dir')->nullable()->comment('Instructions for reading the meter on this machine.');
                $table->char('is_color', 1)->nullable()->comment('Was 0 or 1 before. Is this a color machine? Y=yes, N=no');
                $table->char('auto_created', 1)->nullable()->comment('Was this record auto-generated? Y=yes, N=no');

                /*New columns that were not in original table*/
                $table->timestamp('created_date')->useCurrent();
                $table->integer('created_by');
                $table->timestamp('modified_date')->useCurrent();
                $table->integer('modified_by');
                $table->dateTime('deleted_at')->nullable();

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
        Schema::dropIfExists('machines');
    }
}
