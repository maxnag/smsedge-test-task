<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use App\Migration;

/**
 * Class CreateNumbersTable
 */
class CreateNumbersTable extends Migration {
    CONST TABLE_NAME = 'numbers';

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
                $table->increments('num_id');
                $table->unsignedInteger('cnt_id')->nullable();
                $table->string('num_number', 100)->nullable();
                $table->timestamp('num_created')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('num_modify')->nullable();

                // list of indexes
                $table->index('cnt_id', 'country');

                // list of foreign indexes
                $table->foreign('cnt_id', $this->createFKname(CreateCountriesTable::TABLE_NAME))
                    ->references('cnt_id')->on(CreateCountriesTable::TABLE_NAME)->onUpdate('CASCADE')->onDelete('SET NULL');
            });

            DB::statement('ALTER TABLE ' . DB::getTablePrefix() . self::TABLE_NAME . ' COMMENT "numbers table"');
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
            $table->dropForeign($this->createFKname(CreateCountriesTable::TABLE_NAME));
        });

        Schema::dropIfExists(self::TABLE_NAME);
    }
}
