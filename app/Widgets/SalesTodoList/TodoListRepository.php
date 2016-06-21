<?php

namespace App\Widgets\SalesTodoList;

interface TodoListRepository
{
    /**
     * @param int $userId
     * @param int $itemsPerPage
     *
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function getPaginatedForUser(int $userId, int $itemsPerPage) : \Illuminate\Contracts\Pagination\Paginator;
}
