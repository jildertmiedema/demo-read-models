<?php
declare(strict_types = 1);

namespace App\Widgets\AppointmentFilter;

final class Result
{
    /**
     * @var int
     */
    private $page;
    /**
     * @var int
     */
    private $pages;
    /**
     * @var array
     */
    private $items;
    /**
     * @var Query
     */
    private $query;

    public function __construct(Query $query, int $page, int $pages, array $items)
    {
        $this->page = $page;
        $this->pages = $pages;
        $this->items = $items;
        $this->query = $query;
    }

    /**
     * @return int
     */
    public function page(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function pages(): int
    {
        return $this->pages;
    }

    /**
     * @return array
     */
    public function items(): array
    {
        return $this->items;
    }

    /**
     * @return Query
     */
    public function query(): Query
    {
        return $this->query;
    }

}
