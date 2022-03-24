<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->increments('org_id', 11);
            $table->string('org_name', 75)->comment = 'Name of the organization';
			$table->string('org_short_name', 15)->nullable() ->comment = 'Abbreviated name of the organization';
			$table->integer('organization_types_id')->nullable()->comment="FK to organization_type.id";
			$table->string('website', 100)->nullable();
			$table->date('last_update')->nullable();
			$table->string('org_comments', 700)->nullable();
			$table->date('client_since')->nullable();
			$table->char('client_status', 1)->nullable()->comment="Is the client an active client? A=Active P=Prospective I=Inactive N=NonActive";
			$table->char('print_mgmt_software_installed', 1)->nullable()->comment="Is the client active on stardoc? Y=Yes N=No";
			$table->char('lenp_contract_signed', 1)->nullable()->comment="Y=Yes N=No";
			$table->integer('fmaudit_client_id')->nullable();
			$table->date('commencement_date')->nullable();
			$table->char('display_meter_data', 1)->nullable()->comment="Y=Yes N=No";
			$table->string('meter_data_feed', 10)->nullable();
			$table->string('client_logo', 30)->nullable();
			$table->string('gm_notes', 300)->nullable();
			$table->string('org_message', 300)->nullable();
			$table->decimal('bank_buyout', 11,2)->nullable();
			$table->decimal('spc_service_fee', 11,2)->nullable();
			$table->integer('trade_out_deletion')->nullable();
			$table->date('new_upgrade_date')->nullable();
			$table->char('temp_inactive', 1)->default("N")->comment="Y means temporarily inactive during upgrade. Defaults to N for No. Used in reports.";
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
        Schema::dropIfExists('organizations');
    }
}
