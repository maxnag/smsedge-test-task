<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use App\Migration;

/**
 * Class CreateSendLogTable
 */
class CreateSendLogTable extends Migration {
    CONST TABLE_NAME = 'send_log';

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
                $table->increments('log_id');
                $table->unsignedInteger('usr_id')->nullable();
                $table->unsignedInteger('num_id')->nullable();
                $table->string('log_message', 100)->nullable();
                $table->boolean('log_success')->nullable();
                $table->timestamp('log_created')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('log_modify')->nullable();

                // list of indexes
                $table->index('usr_id', 'user');
                $table->index('num_id', 'number');

                // list of foreign indexes
                $table->foreign('usr_id', $this->createFKname(CreateUsersTable::TABLE_NAME))
                    ->references('usr_id')->on(CreateUsersTable::TABLE_NAME)->onUpdate('CASCADE')->onDelete('SET NULL');
                $table->foreign('num_id', $this->createFKname(CreateNumbersTable::TABLE_NAME))
                    ->references('num_id')->on(CreateNumbersTable::TABLE_NAME)->onUpdate('CASCADE')->onDelete('SET NULL');
            });

            DB::statement('ALTER TABLE ' . DB::getTablePrefix() . self::TABLE_NAME . ' COMMENT "send_log table"');
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
            $table->dropForeign($this->createFKname(CreateUsersTable::TABLE_NAME));
            $table->dropForeign($this->createFKname(CreateNumbersTable::TABLE_NAME));
        });

        Schema::dropIfExists(self::TABLE_NAME);
    }
}
