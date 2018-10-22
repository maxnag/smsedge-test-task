<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class SendLogsTableSeeder extends Seeder
{
    CONST TABLE_NAME ='send_log';

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table(self::TABLE_NAME)->delete();

        DB::table(self::TABLE_NAME)->insert([
            [
                'log_id' => 1,
                'usr_id' => 1,
                'num_id' => 1,
                'log_message' => 'message',
                'log_success' => 1,
                'log_created' => date('Y-m-d H:i:s'),
            ],
        ]);
    }
}
