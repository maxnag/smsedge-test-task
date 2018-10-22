<?php

namespace App\API\V1\Classes\Argument;

/**
 * API masterzoo masterzoo
 * Argument class
 *
 * @package core
 * @subpackage masterzoo masterzoo
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class Argument
{
    /**
     * @var Body
     */
    private $body;

    /**
     * @var Page
     */
    private $page;

    /**
     * @var Sort
     */
    private $sorts;

    /**
     * @var Filter
     */
    private $filters;

    /**
     * Argument constructor.
     */
    public function __construct()
    {
        $this->filters = new Filter;
        $this->sorts = new Sort(new Collection);
        $this->page = new Page;
        $this->body = new Body;
    }

    /**
     * Get page
     *
     * @return Page
     */
    public function getPage(): Page
    {
        return $this->page;
    }

    /**
     * Set page
     *
     * @param array $page
     *
     * @return $this
     */
    public function setPage(array $page): self
    {
        $this->page->set($page);

        return $this;
    }

    /**
     * Get sorts
     *
     * @return Sort
     */
    public function getSorts(): Sort
    {
        return $this->sorts;
    }

    /**
     * Set sorts
     *
     * @param string|array $sorts
     *
     * @return $this
     */
    public function setSorts($sorts): self
    {
        $this->sorts->set($sorts);

        return $this;
    }

    /**
     * Get filters
     *
     * @return Filter|\stdClass
     */
    public function getFilters(): Filter
    {
        return $this->filters;
    }

    /**
     * Set filters
     *
     * @param array $filters
     *
     * @return $this
     */
    public function setFilters($filters): self
    {
        $this->filters->set($filters);

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody(): string
    {
        return $this->body->get();
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return $this
     */
    public function setBody($body): self
    {
        $this->body->set($body);

        return $this;
    }
}
