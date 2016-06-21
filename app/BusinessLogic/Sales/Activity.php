<?php

namespace App\BusinessLogic\Sales;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'sales_activities';

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function status()
    {
        return $this->belongsTo(State::class);
    }

    public function firstOpenAppointment()
    {
        return $this->hasOne(Appointment::class, 'activity_id')
            ->where('done', 0)
            ->orderBy('date')
            ->orderBy('time');
    }
}
