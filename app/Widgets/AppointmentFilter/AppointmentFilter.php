<?php
declare(strict_types = 1);

namespace App\Widgets\AppointmentFilter;

interface AppointmentFilter
{
    public function query(Query $query): Result;
}
