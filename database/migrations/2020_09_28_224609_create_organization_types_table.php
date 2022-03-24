<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_types', function (Blueprint $table) {
            $table->bigIncrements('org_type_id');
            $table->string('org_type_name', 25);
        	$table->timestamp('created_date')->useCurrent();
			$table->integer('created_by')->default(1271);
			$table->timestamp('modified_date')->useCurrent();
			$table->integer('modified_by')->default(1271);
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
        Schema::dropIfExists('organization_types');
    }
}
