<?php

namespace App\API\V1\Classes\Argument;

/**
 * API masterzoo masterzoo
 * Page class
 *
 * @package core
 * @subpackage masterzoo masterzoo
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class Page
{
    private $page = 1;
    private $offset = 0;
    private $size = 0;

    /**
     * Get page number
     *
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * Get offset
     *
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * Get size
     *
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * Set data of page
     *
     * @param array $page
     *
     * @return $this
     */
    public function set(array $page = []): self
    {
        if (!empty($page)) {
            $this->size = !empty($page['size'])
                ? (int)$page['size']
                : 10
            ;

            $this->size = isset($page['size']) && $page['size'] === -1
                ? 0
                : $this->size
            ;

            $offset = (!empty($page['number']) && (int)$page['number'] <= 1)
                ? 0
                : $page['number'] * $this->size - $this->size
            ;

            $offset = $offset <= 0
                ? 0
                : $offset
            ;

            $pageNumber = (!empty($page['number']) && (int)$page['number'] <= 1)
                ? 1
                : $page['number']
            ;

            $this->offset = $offset;
            $this->page = $pageNumber;
        } else {
            $this->page = 0;
            $this->size = 10;
        }

        return $this;
    }
}
