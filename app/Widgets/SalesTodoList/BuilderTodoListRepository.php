<?php

namespace App\Widgets\SalesTodoList;

use App\BusinessLogic\Sales\Activity;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class BuilderTodoListRepository implements TodoListRepository
{
    /**
     * @param int $userId
     * @param int $itemsPerPage
     *
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function getPaginatedForUser(int $userId, int $itemsPerPage) : \Illuminate\Contracts\Pagination\Paginator
    {
        $data = Activity::query();
        $data->with('account');
        $data->with('project');
        $data->with('project.user');
        $data->with('status');
        $data->with('firstOpenAppointment');

        $data->join(
            'sales_appointments as appointment_first',
            'appointment_first.activity_id',
            '=',
            'sales_activities.id',
            'inner'
        );
        $data->where('appointment_first.done', '0');

        $data->whereHas('project', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });

        $data->groupBy('sales_activities.id');
        $data->select('sales_activities.*');
        $data->orderBy(\DB::raw('min(appointment_first.date)'), 'asc');
        if (\DB::getConfig(null)['driver'] == 'mysql') {
            $data->orderBy(\DB::raw('ISNULL(appointment_first.time)'), 'asc');
        } else {
            $data->orderBy(\DB::raw('ifnull(appointment_first.time, 9999999999999)'), 'asc');
        }
        $data->orderBy(\DB::raw('min(appointment_first.time)'), 'asc');

        $date = new Carbon();
        $beginDate = clone $date;
        $endDate = clone $date;

        $data->whereHas('firstOpenAppointment', function ($q) use ($beginDate, $endDate) {
            $q->whereRaw('DATE(date) <= "' . $beginDate->format('Y-m-d') . '"');
        });

        $paginatedItems = $data->paginate($itemsPerPage);

        return mapPaginator($paginatedItems, function (Activity $activity) {
            $todoItem = new TodoItem();

            $todoItem->activityId = $activity->id;
            $todoItem->accountName = $activity->account->name;
            $todoItem->accountPhone = $activity->account->phone;
            $todoItem->accountWebsite = $activity->account->website;
            $todoItem->projectName = $activity->project->name;
            $todoItem->appointmentDate = $activity->firstOpenAppointment->date->format('Y-m-d');
            $todoItem->appointmentTime  = $activity->firstOpenAppointment->time;
            $todoItem->state = $activity->status->name;
            $todoItem->class = null;

            return $todoItem;
        });
    }
}
