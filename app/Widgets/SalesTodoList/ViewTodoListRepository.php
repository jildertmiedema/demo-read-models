<?php

namespace App\Widgets\SalesTodoList;

use Illuminate\Contracts\Pagination\Paginator;

class ViewTodoListRepository implements TodoListRepository
{

    /**
     * @param int $userId
     * @param int $itemsPerPage
     *
     * @return Paginator
     */
    public function getPaginatedForUser(int $userId, int $itemsPerPage) : Paginator
    {
        $paginatedItems = \DB::table('todo_list')
            ->where('user_id', $userId)
            ->paginate($itemsPerPage);

        return mapPaginator($paginatedItems, mapTo(TodoItem::class));
    }
}
