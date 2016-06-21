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

        $items = collect($paginatedItems->items())
            ->map(function ($item) {
                $todoItem = new TodoItem();

                $todoItem->activityId = $item->id;
                $todoItem->accountName = $item->account_name;
                $todoItem->accountPhone = $item->account_phone;
                $todoItem->accountWebsite = $item->account_website;
                $todoItem->projectName = $item->project_name;
                $todoItem->appointmentDate = $item->appointment_date;
                $todoItem->appointmentTime  = $item->appointment_time;
                $todoItem->status = $item->state;

                return $todoItem;
            });


        return new LengthAwarePaginator($items, $paginatedItems->total(), $paginatedItems->perPage(), $paginatedItems->currentPage(), [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);
    }
}
