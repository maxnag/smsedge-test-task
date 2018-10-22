<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CountriesTableSeeder extends Seeder
{
    CONST TABLE_NAME ='countries';

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
                'cnt_id' => 1,
                'cnt_code' => 'IL',
                'cnt_title' => 'Israel',
            ],
            [
                'cnt_id' => 2,
                'cnt_code' => 'UA',
                'cnt_title' => 'Ukraine',
            ],
        ]);
    }
}
