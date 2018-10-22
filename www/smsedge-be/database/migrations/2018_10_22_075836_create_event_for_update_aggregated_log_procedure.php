<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventForUpdateAggregatedLogProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = <<<PROC
SET GLOBAL event_scheduler = ON;
        
DROP PROCEDURE IF EXISTS `event_call_aggregated_log_procedure`;
        
CREATE DEFINER=`root`@`%` EVENT `event_call_aggregated_log_procedure`
	ON SCHEDULE
		EVERY 1 MINUTE STARTS '2018-10-22 00:00:00'
	ON COMPLETION PRESERVE
	ENABLE
	COMMENT ''
	DO BEGIN
        CALL update_aggregated_log_table();
        CALL remove_raw_data_from_send_log_table();
    END
PROC;

        DB::unprepared($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP PROCEDURE IF EXISTS `event_call_aggregated_log_procedure`;');
    }
}
