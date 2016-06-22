<?php

namespace App\Widgets\SalesTodoList;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class InMemoryTodoListRepository implements TodoListRepository
{

    /**
     * @param int $userId
     * @param int $itemsPerPage
     *
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function getPaginatedForUser(int $userId, int $itemsPerPage) : \Illuminate\Contracts\Pagination\Paginator
    {
        $paginatedItems = \DB::table('todo_list_memory')
            ->where('user_id', $userId)
            ->paginate($itemsPerPage);

        return mapPaginator($paginatedItems, mapTo(TodoItem::class));
    }
}
