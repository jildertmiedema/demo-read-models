<?php

namespace App\Widgets\SalesTodoList;

use Illuminate\Database\Connection;

class TableTodoListRepository implements TodoListRepository
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param int $userId
     * @param int $itemsPerPage
     *
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function getPaginatedForUser(int $userId, int $itemsPerPage) : \Illuminate\Contracts\Pagination\Paginator
    {
        $paginatedItems = $this->connection->table('todo_list_memory')
            ->where('user_id', $userId)
            ->paginate($itemsPerPage);

        return mapPaginator($paginatedItems, mapTo(TodoItem::class));
    }
}
