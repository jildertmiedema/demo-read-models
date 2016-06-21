<?php

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
