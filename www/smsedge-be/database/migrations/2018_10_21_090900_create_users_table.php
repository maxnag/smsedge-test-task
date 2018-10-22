<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use App\Migration;

/**
 * Class CreateUsersTable
 */
class CreateUsersTable extends Migration {
    CONST TABLE_NAME = 'users';

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
                $table->increments('usr_id');
                $table->string('usr_name', 100)->nullable();
                $table->boolean('usr_active')->nullable()->default(1);
                $table->timestamp('usr_created')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('usr_modify')->nullable();

                // list of indexes

                // list of foreign indexes
//                $table->foreign('city_id', $this->createFKname(CreateCatalogCitiesTable::TABLE_NAME))
//                    ->references('id')->on(CreateCatalogCitiesTable::TABLE_NAME)->onUpdate('CASCADE')->onDelete('SET NULL');
//                $table->foreign('position_id', $this->createFKname(CreateCatalogPositionsTable::TABLE_NAME))
//                    ->references('id')->on(CreateCatalogPositionsTable::TABLE_NAME)->onUpdate('CASCADE')->onDelete('SET NULL');
//                $table->foreign('shop_id', $this->createFKname(CreateCatalogShopsTable::TABLE_NAME))
//                    ->references('id')->on(CreateCatalogShopsTable::TABLE_NAME)->onUpdate('CASCADE')->onDelete('SET NULL');
            });

            DB::statement('ALTER TABLE ' . DB::getTablePrefix() . self::TABLE_NAME . ' COMMENT "users table"');
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
//            $table->dropForeign($this->createFKname(CreateCatalogCitiesTable::TABLE_NAME));
//            $table->dropForeign($this->createFKname(CreateCatalogPositionsTable::TABLE_NAME));
//            $table->dropForeign($this->createFKname(CreateCatalogShopsTable::TABLE_NAME));
        });

        Schema::dropIfExists(self::TABLE_NAME);
    }
}
