<?php
namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class ValidationException
 *
 * @package  api
 * @subpackage academy masterzoo
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class ValidationException extends HttpException
{
    private $data;

    /**
     * ValidationException constructor.
     *
     * @param array $data
     * @param integer $statusCode
     */
    public function __construct($data, $statusCode = 422)
    {
        parent::__construct($statusCode, 'The given data was invalid.');

        $this->data = $data;
    }

    /**
     * Output data
     *
     * @return array
     */
    public function getOutput(): array
    {
        return $this->data;
    }
}