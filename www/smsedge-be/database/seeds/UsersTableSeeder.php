<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    CONST TABLE_NAME ='users';

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
                'usr_id' => 1,
                'usr_name' => 'user 1',
                'usr_active' => 1,
            ],
            [
                'usr_id' => 2,
                'usr_name' => 'user 2',
                'usr_active' => 1,
            ],
        ]);
    }
}
