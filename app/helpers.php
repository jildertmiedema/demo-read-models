<?php

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

function money($value)
{
    return sprintf("€ %0.2f", $value);
}

function row_class($item)
{
    $time = $item->firstOpenAppointment->time ?: '23:59:59';
    $diff = $item->firstOpenAppointment->minutesToGo();
    if ($diff < -30 || ! $time) {
        return '';
    }

    return diffToClass($diff);
}

function time_class($item)
{
    $diff = $item->firstOpenAppointment->minutesToGo();
    if ($diff < -30 || ! $item->firstOpenAppointment->time) {
        return '';
    }
    $class = diffToClass($diff);

    return '<span class="label label-' . $class . '">&nbsp;</span>';
}

function label_span($class)
{
    return '<span class="label label-' . $class . '">&nbsp;</span>';
}

function diffToClass($diff)
{
    if ($diff > 30) {
        return 'danger';
    } elseif ($diff > 0) {
        return 'warning';
    } elseif ($diff > -30) {
        return 'info';
    } else {
        return '';
    }
}

function mapTo($class)
{
    return function ($data) use ($class){
        $item = new $class;

        if ($data instanceof Model) {
            $data = $data->toArray();
        } else {
            $data = get_object_vars($data);
        }

        foreach ($data as $field => $value) {
            if (strpos($field, '_')) {
                $field = Str::camel($field);
            }
            if (property_exists($item, $field)) {
                $item->$field = $value;
            }
        }

        return $item;
    };
}


function mapPaginator(Paginator $paginator, \Closure $mapper)
{
    $items = collect($paginator->items())
        ->map($mapper);

    return new LengthAwarePaginator($items, $paginator->total(), $paginator->perPage(), $paginator->currentPage(), [
        'path' => LengthAwarePaginator::resolveCurrentPath(),
        'pageName' => 'page',
    ]);
}