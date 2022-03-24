<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buildings', function (Blueprint $table) {
            $table->bigIncrements('bldg_id');
            $table->integer('organizations_id');
			$table->string('bldg_name', 40);
			$table->string('bldg_name_short', 25)->nullable()->comment('This is for use in graphs so the name will fit.');
			$table->integer('student_pop')->nullable()->comment('The student population for this building.');
			$table->decimal('bldg_equip_cost', 11, 2)->nullable()->comment('A field where Pam manually enters data.');
			$table->text('notes')->nullable();
			$table->dateTime('created_date')->useCurrent()->comment('Date and time record was created.');
			$table->integer('created_by');
			$table->dateTime('modified_date')->useCurrent();
			$table->integer('modified_by');
        	$table->dateTime('deleted_at')->nullable();
        	
        	/*Point a foreign key to the organizations table*/
        	$table->foreign('organizations_id')->references('id')->on('organizations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buildings');
    }
}
