<?php

namespace App\Widgets\SalesTodoList;

use Carbon\Carbon;

class TimeClassDecorator implements TodoListRepository
{

    /**
     * @var TodoListRepository
     */
    private $repository;

    public function __construct(TodoListRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $userId
     * @param int $itemsPerPage
     *
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function getPaginatedForUser(int $userId, int $itemsPerPage) : \Illuminate\Contracts\Pagination\Paginator
    {
        $now = Carbon::now();
        $result = $this->repository->getPaginatedForUser($userId, $itemsPerPage);
        collect($result->items())
            ->each(function (TodoItem $item) use ($now) {

                $date = new Carbon($item->appointmentDate . ' ' . ($item->appointmentTime ?: '23:59:59'));

                $diff = $date->diffInMinutes($now, false);

                if ($diff < -30) {
                    return '';
                }

                $item->class = diffToClass($diff);
            });

        return $result;
    }
}
