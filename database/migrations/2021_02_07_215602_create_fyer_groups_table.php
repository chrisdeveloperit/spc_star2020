<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFyerGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('fyer_groups')) {
            Schema::create('fyer_groups', function (Blueprint $table) {
                $table->increments('fyer_grp_id', 11);
                $table->integer('organizations_id');
                $table->integer('school_year');
                $table->string('fyer_proposed_vendor', 100)->nullable()->comment="Proposed Vendor";
                $table->string('fyer_name', 100)->nullable();
                $table->char('fyer_final', 1)->default("N")->nullable()->comment="Y=Yes N=No";
                $table->dateTime('survey_date')->nullable();
                $table->dateTime('upgrade_date')->nullable();
                $table->decimal('fyer_govt_lease', 12, 2)->nullable();
                $table->timestamp('created_date')->useCurrent();
                $table->integer('created_by')->default(1271);
                $table->timestamp('modified_date')->useCurrent();
                $table->integer('modified_by')->default(1271);
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
        Schema::dropIfExists('fyer__groups');
    }
}
