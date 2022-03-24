<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailGroupTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_group_titles', function (Blueprint $table) {
            $table->bigIncrements('email_grp_id');
            $table->string('email_group_title', 30)->comment('SPC defined title used for sending group emails.');
            $table->timestamp('created_date')->useCurrent()->comment('Date and time email_group_title was created.');
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
        Schema::dropIfExists('email_group_titles');
    }
}
