<?php
declare(strict_types = 1);

namespace App\BusinessLogic\Sales;

final class AppointmentWasCompleted
{
    private $appointmentId;
    private $time;

    /**
     * @param int $appointmentId
     * @param string $time
     */
    public function __construct(int $appointmentId, string $time)
    {
        $this->appointmentId = $appointmentId;
        $this->time = $time;
    }

    /**
     * @return int
     */
    public function appointmentId()
    {
        return $this->appointmentId;
    }

    /**
     * @return string
     */
    public function time()
    {
        return $this->time;
    }
}
