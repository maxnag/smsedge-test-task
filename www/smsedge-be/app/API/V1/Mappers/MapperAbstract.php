<?php

namespace App\API\V1\Mappers;

use App\API\V1\Classes\MapIdentity;
use App\API\V1\Classes\Registry;

/**
 * Map Identity implementation
 * Map Identity class
 *
 * @codeCoverageIgnore
 *
 * @package  api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
abstract class MapperAbstract
{
    /**
     * @var MapIdentity
     */
    protected $identityMap;

    /**
     * @var Registry
     */
    protected $registry;
    
    /**
     * Mapper constructor.
     *
     * @param Registry $registry
     * @param mixed $adapterClassName
     */
    abstract public function __construct(Registry $registry, $adapterClassName = '');

    /**
     * Get Registry
     *
     * @return Registry
     */
    public function getRegistry(): Registry
    {
        return $this->registry;
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        unset($this->identityMap, $this->registry);
    }
}
