<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use App\Migration;

/**
 * Class CreateSendLogAggregatedTable
 */
class CreateSendLogAggregatedTable extends Migration {
    CONST TABLE_NAME = 'send_log_aggregated';

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
                $table->increments('id');
                $table->date('date')->nullable();
                $table->unsignedInteger('usr_id')->nullable();
                $table->string('usr_name', 100)->nullable();
                $table->string('cnt_code', 2)->nullable();
                $table->string('cnt_title', 100)->nullable();
                $table->unsignedInteger('success')->nullable();
                $table->unsignedInteger('fail')->nullable();
                $table->text('ids')->nullable();

                // list of indexes
                $table->index('usr_id', 'user');
                $table->index(['cnt_code', 'cnt_title'], 'country');
                $table->index('date', 'date');

                // list of foreign indexes
            });

            DB::statement('ALTER TABLE ' . DB::getTablePrefix() . self::TABLE_NAME . ' COMMENT "send_log_aggregated table"');

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
