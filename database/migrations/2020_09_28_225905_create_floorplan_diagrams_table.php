<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFloorplanDiagramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('floorplan_diagrams', function (Blueprint $table) {
            $table->id();
            $table->dateTime('created_date');
			$table->integer('created_by');
			$table->dateTime('modified_date');
			$table->integer('modified_by');
        	$table->dateTime('deleted_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('floorplan_diagrams');
    }
}
