<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phones', function (Blueprint $table) {
            $table->increments('ph_id', 11);
			$table->char('phone_type', 1) ->comment = 'Type of number M=Main, C=Cell, F=Fax, A=Additional';
			$table->char('owner_type', 1) ->comment = 'The owner of the number can be an org, person, or building O=org, P=person, B=building, U=User';
			$table->integer('owner_id') ->comment = 'The id of the org or the id of the person to whom the number belongs.';
			$table->char('area_code', 3) ->comment = 'The 3 digit area code with no hyphens () or special chars';
			$table->char('exch', 3) ->comment = 'The 3 digit phone exchange with no hyphens () or special chars';
			$table->char('phone_line', 4) ->comment = 'The last 4 digits of the phone number are the actual phone line';
			$table->char('extension', 8)->nullable()->comment = 'If there is a specific extension, it will be here.';
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
        Schema::dropIfExists('phones');
    }
}
