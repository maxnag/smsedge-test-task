<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpdateRemoveRawDataFromSendLogProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = <<<PROC
DROP PROCEDURE IF EXISTS `update_aggregated_log_table`;
        
CREATE DEFINER=`root`@`%` PROCEDURE `update_aggregated_log_table`()
LANGUAGE SQL
NOT DETERMINISTIC
CONTAINS SQL
SQL SECURITY DEFINER
COMMENT 'update aggregated table and remove raw data from send log table'
BEGIN
	REPLACE INTO `send_log_aggregated` (`id`,`date`,`usr_id`,`usr_name`,`cnt_code`,`cnt_title`,`success`,`fail`,`ids`)
		SELECT SUM(id) as `id`, agg.`date`, agg.usr_id, agg.usr_name, agg.cnt_code, agg.cnt_title, SUM(agg.success) `success`, SUM(agg.fail) `fail`, `ids`
		FROM (
			SELECT 
				NULL AS id, DATE_FORMAT(sl.log_created, '%Y-%m-%d') `date`, sl.usr_id, u.usr_name, c.cnt_code, c.cnt_title, 
				SUM(IF(sl.log_success = 1, 1, 0)) AS `success`, SUM(IF(sl.log_success = 0, 1, 0)) AS `fail`, 
				GROUP_CONCAT(sl.log_id) `ids`
			FROM send_log sl, numbers n, countries c, users u
			WHERE n.num_id=sl.num_id AND c.cnt_id=n.cnt_id AND u.usr_id = sl.usr_id
			GROUP BY DATE_FORMAT(sl.log_created, '%Y-%m-%d'), sl.usr_id, u.usr_name, c.cnt_id, c.cnt_code, c.cnt_title
			
				UNION ALL
				
			SELECT `id`, `date`, `usr_id`, `usr_name`, `cnt_code`, `cnt_title`, `success`, `fail`, NULL AS `ids`
			FROM send_log_aggregated 
		) agg
		GROUP BY agg.`date`, agg.usr_id, agg.usr_name, agg.cnt_code, agg.cnt_title, agg.ids
	;
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
        DB::statement('DROP PROCEDURE `update_aggregated_log_table`');
    }
}
