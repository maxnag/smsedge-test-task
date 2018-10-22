<?php

namespace App\API\V1\SMSEdge\MySQL;

use Illuminate\Database\Eloquent\Model;

/**
 * SendLogAggregated model
 *
 * @package backend
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 */
class SendLogAggregatedORMModel extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'send_log_aggregated';
}
