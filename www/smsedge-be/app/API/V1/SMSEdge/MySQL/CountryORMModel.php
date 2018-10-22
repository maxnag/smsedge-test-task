<?php

namespace App\API\V1\SMSEdge\MySQL;

use Illuminate\Database\Eloquent\Model;

/**
 * Country model
 *
 * @package backend
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 */
class CountryORMModel extends Model
{
    const CREATED_AT = 'cnt_created';
    const UPDATED_AT = 'cnt_modify';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'countries';
}
