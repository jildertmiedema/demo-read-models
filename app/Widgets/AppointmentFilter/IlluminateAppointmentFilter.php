<?php
declare(strict_types = 1);

namespace App\Widgets\AppointmentFilter;

use Illuminate\Database\Connection;

final class IlluminateAppointmentFilter implements AppointmentFilter
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function query(Query $query): Result
    {
        $selection = $this->connection->table('todo_list')
            ->limit($query->limit());

        foreach ($query->filters() as $field => $value) {
            $selection->where($field, 'like', sprintf('%%%s%%', $value));
        }

        $items = $selection->get()->toArray();

        return new Result($query, 1, 1, $items);
    }
}
