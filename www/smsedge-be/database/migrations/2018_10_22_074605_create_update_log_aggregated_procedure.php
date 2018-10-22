<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpdateLogAggregatedProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = <<<PROC
DROP PROCEDURE IF EXISTS `remove_raw_data_from_send_log_table`;

CREATE DEFINER=`root`@`%` PROCEDURE `remove_raw_data_from_send_log_table`()
LANGUAGE SQL
NOT DETERMINISTIC
CONTAINS SQL
SQL SECURITY DEFINER
COMMENT 'remove raw data from send log table'
BEGIN
	DECLARE done INT DEFAULT 0;
	DECLARE idsForRemove TEXT;
	DECLARE idTable TEXT;
	DECLARE rCursor CURSOR FOR
		SELECT `id`, `ids` FROM `send_log_aggregated` WHERE ids IS NOT NULL;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done=1;
	
	OPEN rCursor;
		remove_process: LOOP
			FETCH rCursor INTO idTable, idsForRemove;
			
			IF done = 1 THEN 
				LEAVE remove_process;
			END IF;
			
			DELETE FROM send_log WHERE FIND_IN_SET(`log_id`, idsForRemove);
			UPDATE send_log_aggregated SET ids = NULL WHERE id = idTable;
		END LOOP remove_process;
	CLOSE rCursor;	
END;
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
        DB::statement('DROP PROCEDURE `remove_raw_data_from_send_log_table`');
    }
}
