<?php

namespace App\API\V1\Classes\Argument;

/**
 * API masterzoo masterzoo
 * Body class
 *
 * @package core
 * @subpackage masterzoo masterzoo
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class Body
{
    private $body = '';

    /**
     * Get body
     *
     * @return string
     */
    public function get(): string
    {
        return $this->body;
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return $this
     */
    public function set($body = ''): self
    {
        $this->body = $body;

        return $this;
    }
}
