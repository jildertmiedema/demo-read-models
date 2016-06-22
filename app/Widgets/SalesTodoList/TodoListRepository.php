<?php

namespace App\Widgets\SalesTodoList;

use Illuminate\Contracts\Pagination\Paginator;

interface TodoListRepository
{
    /**
     * @param int $userId
     * @param int $itemsPerPage
     *
     * @return Paginator
     */
    public function getPaginatedForUser(int $userId, int $itemsPerPage) : Paginator;
}
