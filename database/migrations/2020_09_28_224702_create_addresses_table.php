<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('addr_id');
			$table->char('address_type', 1) ->comment = 'Type of address M=Mailing, L=Legal';
			$table->char('owner_type', 1) ->comment = 'The owner of the address can be an org, person, or building O=Org, P=Person, B=Building';
			$table->integer('owner_id') ->comment = 'The id of the org, person, or building to whom the address belongs.';
			$table->string('address', 50);
			$table->string('address2', 50)->nullable();
			$table->string('city', 50)->nullable();
			$table->string('state', 2)->nullable();
			$table->string('zip_code', 10)->nullable();
			$table->string('county', 25)->nullable();
            $table->timestamp('created_date')->useCurrent();
			$table->integer('created_by');
			$table->timestamp('modified_date')->useCurrent();;
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
        Schema::dropIfExists('addresses');
    }
}
