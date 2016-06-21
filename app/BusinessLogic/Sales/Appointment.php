<?php

namespace App\BusinessLogic\Sales;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{

    protected $table = 'sales_appointments';

    protected $casts = [
        'date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function getDateTimeAttribute()
    {
        return new Carbon($this->date->format('Y-m-d') . ' ' . $this->time);
    }

    public function minutesToGo()
    {
        $now = Carbon::now();
        $date = new Carbon($this->date->format('Y-m-d') . ' ' . ($this->time ?: '23:59:59'));

        $diff = $date->diffInMinutes($now, false);

        return $diff;
    }
}
