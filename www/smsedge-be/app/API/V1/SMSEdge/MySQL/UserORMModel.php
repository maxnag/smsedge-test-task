<?php

namespace App\API\V1\SMSEdge\MySQL;

use Illuminate\Database\Eloquent\Model;

/**
 * User model
 *
 * @package backend
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 */
class UserORMModel extends Model
{
    const CREATED_AT = 'usr_created';
    const UPDATED_AT = 'usr_modify';

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
    protected $table = 'users';
}
