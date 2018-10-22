<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration as MigrationGeneral;

/**
 * Class Migration
 * @package backend
 */
class Migration extends MigrationGeneral
{
    /**
     * Create foreign key name
     *
     * @param string $correspondentTable
     * @param string $postfix
     *
     * @return string
     */
    protected function createFKname($correspondentTable, $postfix = ''): string {
        $prefix = DB::getTablePrefix();
        $postfix = !empty($postfix) ? '_' . $postfix : '';

        return 'FK__' . $prefix . $this::TABLE_NAME .  '__' . $prefix . $correspondentTable . $postfix;
    }
}