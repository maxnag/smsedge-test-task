<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class NumbersTableSeeder extends Seeder
{
    CONST TABLE_NAME ='numbers';

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table(self::TABLE_NAME)->delete();

        $faker = Faker\Factory::create();

        $limit = 10;

        for ($i = 0; $i < $limit; $i++) {
            DB::table(self::TABLE_NAME)->insert([ //,
                'cnt_id' => mt_rand(1, 2),
                'num_number' => $faker->phoneNumber,
                'num_created' => $faker->dateTimeBetween($startDate = '-30 day', $endDate = 'now')
            ]);
        }
    }
}
