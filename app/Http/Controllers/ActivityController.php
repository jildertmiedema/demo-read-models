<?php
declare(strict_types = 1);

namespace App\Http\Controllers;

use App\BusinessLogic\Sales\Activity;
use App\BusinessLogic\Sales\Appointment;

final class ActivityController extends Controller
{
    public function show($id)
    {
        $activity = Activity::findOrFail($id);
        $appointments = $activity->openAppointments;

        return view('activities.show', compact('activity', 'appointments'));
    }

    public function complete($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->complete();

        return redirect()->back();
    }
}
