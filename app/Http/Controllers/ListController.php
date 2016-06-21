<?php

namespace App\Http\Controllers;

use App\BusinessLogic\Sales\Activity;
use App\Widgets\SalesTodoList\TodoItem;
use App\Widgets\SalesTodoList\TodoListRepository;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;

class ListController extends Controller
{
    const ITEMS_PER_PAGE = 25;

    public function todoList()
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

        $data->whereHas('project', function ($q) {
            $q->where('user_id', \Auth::user()->id);
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

        $items = $data->paginate(self::ITEMS_PER_PAGE);
        
        return view('sales.todo', compact('items'));
    }

    public function todoListImproved(TodoListRepository $todos)
    {
        $items = $todos->getPaginatedForUser(\Auth::user()->id, static::ITEMS_PER_PAGE);

        return view('sales.todo-improved', compact('items'));
    }

    public function todoListImprovedView()
    {
        $todos = app('widget-todo.repo.view');
        $items = $todos->getPaginatedForUser(\Auth::user()->id, static::ITEMS_PER_PAGE);

        return view('sales.todo-improved', compact('items'));
    }

    public function todoListImprovedMemory()
    {
        $todos = app('widget-todo.repo.in-memory');
        $items = $todos->getPaginatedForUser(\Auth::user()->id, static::ITEMS_PER_PAGE);

        return view('sales.todo-improved', compact('items'));
    }
}
