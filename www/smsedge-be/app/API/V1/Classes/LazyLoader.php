<?php

namespace App\API\V1\Classes;

/**
 * Lazy loader class
 *
 * @package  api
 * @subpackage SMSEdge test
 * @user Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class LazyLoader
{
    /**
     * @var mixed
     */
    private $mapper;

    /**
     * @var bool
     */
    private $evaluated = false;

    /**
     * LazyLoader constructor.
     * @param mixed $mapper
     */
    public function __construct($mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @return mixed
     */
    public function __invoke()
    {
        if (!$this->evaluated) {
            if (\is_callable($this->mapper)) {
                $this->mapper = \call_user_func($this->mapper);
            }

            $this->evaluated = true;
        }

        return $this->mapper;
    }
}
