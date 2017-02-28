<?php
declare(strict_types = 1);

namespace App\Widgets\AppointmentFilter;

final class Query
{
    private $limit = 15;
    private $filters = [];

    public function __construct()
    {
    }

    public function withFilters(array $filters)
    {
        $this->filters = $filters;

        return $this;
    }

    public function withLimit(int $limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return int
     */
    public function limit(): int
    {
        return $this->limit;
    }

    /**
     * @return array
     */
    public function filters(): array
    {
        return $this->filters;
    }

    public function filter(string $name)
    {
        return array_get($this->filters, $name);
    }

}
