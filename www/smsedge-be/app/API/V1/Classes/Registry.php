<?php

namespace App\API\V1\Classes;

use App\Exceptions\ApiException;

/**
 * Registry class
 *
 * @package  api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class Registry
{
    /**
     * @var array
     */
    private $objects = [];

    /**
     * @var string
     */
    private $version;

    /**
     * Registry constructor.
     *
     * @param string $version
     *
     * @throws ApiException
     */
    public function __construct($version = 'V1')
    {
        $this->version = strtoupper($version);

        $toRegistry = config('smsedge')['Registry'];

        if (!isset($toRegistry[$this->version])) {
            throw new ApiException(404, __('The registry for :version not found in :config', ['version' => $this->version, 'config' => 'smsedge']));
        }

        /** @var array $classes */
        $classes = $toRegistry[$this->version];

        foreach ($classes as $key => $registry) {
            // @codeCoverageIgnoreStart
            if (!\class_exists($registry)) {
                throw new ApiException(404, __('The class :class does not exist, maybe mistake in name.', ['class' => $registry]));
            }
            // @codeCoverageIgnoreEnd

            // TODO better to use lazy loading, not all object need to work per run
            $this->set($key, new $registry);
        }
    }

    /**
     * Set object instance
     *
     * @param string $key
     * @param object $value
     *
     * @return $this
     */
    public function set($key, $value)
    {
        $this->objects[$this->version][$key] = $value;

        return $this;
    }

    /**
     * Get object
     *
     * @param string $key
     *
     * @throws ApiException
     *
     * @return object
     */
    public function get($key)
    {
        if ($this->isRegistered($key)) {
            return $this->objects[$this->version][$key];
        }

        throw new ApiException(405, __('The class :class not registered.', ['class' => $key]));
    }

    /**
     * Check
     *
     * @param string $key
     *
     * @return bool
     */
    public function isRegistered($key): bool
    {
        return isset($this->objects[$this->version][$key]);
    }

    /**
     * Remove object
     *
     * @param string $key
     *
     * @return void
     */
    public function remove($key)
    {
        unset($this->objects[$this->version][$key]);
    }
}
