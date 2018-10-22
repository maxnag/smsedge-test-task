<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use App\Migration;

/**
 * Class CreateCountriesTable
 */
class CreateCountriesTable extends Migration {
    CONST TABLE_NAME = 'countries';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable(self::TABLE_NAME)) {
            Schema::disableForeignKeyConstraints();
            Schema::create(self::TABLE_NAME, function (Blueprint $table) {
                // table description
                $table->engine = 'InnoDB';
                $table->charset = env('DB_CHARSET', 'utf8');
                $table->collation = env('DB_COLLATION', 'utf8_general_ci');

                // list of columns with settings
                $table->increments('cnt_id');
                $table->string('cnt_code', 2)->nullable();
                $table->string('cnt_title', 100)->nullable();
                $table->timestamp('cnt_created')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('cnt_modify')->nullable();

                // list of indexes
                $table->unique('cnt_code', 'unique');

                // list of foreign indexes
            });

            DB::statement('ALTER TABLE ' . DB::getTablePrefix() . self::TABLE_NAME . ' COMMENT "countries table"');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(self::TABLE_NAME, function(Blueprint $table) {
        });

        Schema::dropIfExists(self::TABLE_NAME);
    }
}
