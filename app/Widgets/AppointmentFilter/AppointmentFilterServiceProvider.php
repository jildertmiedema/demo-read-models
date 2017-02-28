<?php
declare(strict_types = 1);

namespace App\Widgets\AppointmentFilter;

use Illuminate\Support\ServiceProvider;

final class AppointmentFilterServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(AppointmentFilter::class, IlluminateAppointmentFilter::class);
    }
}
