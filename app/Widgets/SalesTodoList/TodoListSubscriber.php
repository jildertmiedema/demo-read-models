<?php
declare(strict_types = 1);

namespace App\Widgets\SalesTodoList;

use App\BusinessLogic\Sales\AppointmentWasCompleted;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Connection;

final class TodoListSubscriber
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function handle($event)
    {
        if ($event instanceof AppointmentWasCompleted) {
            $this->connection->table('todo_list_memory')
                ->where('appointment_id', $event->appointmentId())
                ->delete();
        }
    }

    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            AppointmentWasCompleted::class,
            [$this, 'handle']
        );
    }
}
