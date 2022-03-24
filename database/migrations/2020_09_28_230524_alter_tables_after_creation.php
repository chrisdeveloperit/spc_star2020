<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTablesAfterCreation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $statementPeople = "ALTER TABLE people AUTO_INCREMENT = 1475;";
        DB::unprepared($statementPeople);
		
		$statementOrg = "ALTER TABLE organizations AUTO_INCREMENT = 2000;";
        DB::unprepared($statementOrg);
		
		$statementMeters = "ALTER TABLE meters AUTO_INCREMENT = 15000000;"; //current max = 12860936
        DB::unprepared($statementMeters);
    
    	/*$statementMachineStatus = "ALTER TABLE y2019_machine_status ADD INDEX idx_serNum_date (serial_number, date_timestamp)";
   		DB::unprepared($statementMachineStatus);*/
   		
   		//DB::statement('ALTER TABLE buildings ENGINE = InnoDB'); just a thought
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
