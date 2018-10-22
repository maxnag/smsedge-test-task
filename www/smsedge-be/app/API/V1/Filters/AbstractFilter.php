<?php

namespace App\API\V1\Filters;

/**
 * API SMSEdge test
 * Abstract class for filtering data
 *
 * @package  api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
abstract class AbstractFilter
{
    /**
     * @var array
     */
    protected $rawData = [];

    /**
     * @var mixed
     */
    protected $object;

    /**
     * @var FilterHelper
     */
    protected $filterHelper;

    /**
     * AbstractFilter constructor.
     *
     * @param object|null $entity
     *
     * @throws \ReflectionException
     */
    public function __construct($entity = null)
    {
        if ($entity !== null) {
            $this->setData($entity);
        }
    }

    /**
     * Set entity data
     *
     * @param object $entity
     *
     * @throws \ReflectionException
     *
     * @return $this
     */
    public function setData($entity): self
    {
        $this->object = $entity;
        $this->rawData = $entity->getArray();
        $this->filterHelper = new FilterHelper;

        foreach ($this->rawData as $field => $value) {
            if (empty($value) || \is_array($value) || \is_object($value)) {
                continue;
            }

            $rawFieldName = $field;
            $field = preg_replace_callback('/(?:^|_)([a-z])/', function ($matches) {
                return strtoupper($matches[1]);
            }, strtolower($field));

            $this->object->{'set' . $field}($this->runFilter($rawFieldName, $value));
        }

        return $this;
    }

    /**
     * Get data
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->object;
    }

    /**
     * Get rules
     *
     * @return array
     */
    public function getRules(): array
    {
        return $this->prepareRules();
    }

    /**
     * Fields for filtering
     *
     * @return array
     */
    abstract protected function prepareRules(): array;

    /**
     * Filters a value for a specific column
     * Taken from Kohana_ORM
     *
     * Examples
     *
     * public function filters()
     * {
     *     return [
     *         // Field Filters
     *         // $field_name => [mixed $callback[, array $params = [':value']]],
     *         'username' => [
     *             // PHP Function Callback, default implicit param of ':value'
     *             ['trim'],
     *         ],
     *         'password' => [
     *             // Callback method with object context and params
     *             [[$this, 'hash_password'], [':value', Model_User::salt()]],
     *         ],
     *         'created_on' => [
     *             // Callback static method with params
     *             ['Format::date', [':value', 'Y-m-d H:i:s']],
     *         ],
     *         'other_field' => [
     *
     *             // Callback static method with implicit param of ':value'
     *             ['MyClass::static_method'],
     *
     *             // Callback method with object context with implicit param of ':value'
     *             [[$this, 'change_other_field']],
     *
     *             // PHP function callback with explicit params
     *             ['str_replace', ['luango', 'thomas', ':value']],
     *
     *             // Function as the callback (PHP 5.3+)
     *             [function($value) {
     *                 // Do something to $value and return it.
     *                 return some_function($value);
     *             }],
     *         ],
     *     ];
     * }
     *
     * @param  string $field The column name
     * @param  string $value The value to filter
     *
     * @throws \ReflectionException
     *
     * @return string
     */
    protected function runFilter($field, $value): string
    {
        $filters = $this->prepareRules();

        // Get the filters for this column
        $wildcards = empty($filters[true]) ? [] : $filters[true];

        // Merge in the wildcards
        $filters = empty($filters[$field]) ? $wildcards : array_merge($wildcards, $filters[$field]);

        // Bind the field name and model so they can be used in the filter method
        $bound = [
            ':field' => $field,
            ':model' => $this,
        ];

        foreach ($filters as $array) {
            // Value needs to be bound inside the loop so we are always using the
            // version that was modified by the filters that already ran
            $bound[':value'] = $value;

            // Filters are defined as array($filter, $params)
            $filter = $array[0];
            $params = $this->get($array, 1, [':value']);

            foreach ($params as $key => $param) {
                if (\is_string($param) && array_key_exists($param, $bound)) {
                    // Replace with bound value
                    $params[$key] = $bound[$param];
                }
            }

            if (\is_array($filter) || !\is_string($filter)) {
                // This is either a callback as an array or a lambda
                $value = \call_user_func_array($filter, $params);
            } elseif (strpos($filter, '::') === FALSE) {
                // Use a function call
                $function = new \ReflectionFunction($filter);

                // Call $function($this[$field], $param, ...) with Reflection
                $value = $function->invokeArgs($params);
            } else {
                // Split the class and method of the rule
                list($class, $method) = explode('::', $filter, 2);

                // Use a static method call
                $method = new \ReflectionMethod($class, $method);

                // Call $Class::$method($this[$field], $param, ...) with Reflection
                $value = $method->invokeArgs(NULL, $params);
            }
        }

        return $value;
    }

    /**
     * Retrieve a single key from an array. If the key does not exist in the
     * array, the default value will be returned instead.
     *
     * @param   array $array array to extract from
     * @param   string $key key name
     * @param   mixed $default default value
     * @return  null|array
     */
    protected function get($array, $key, $default = NULL)
    {
        return $array[$key] ?? $default;
    }
}
