<?php
declare(strict_types = 1);

namespace App\Widgets\SalesTodoList;

use Illuminate\Database\Connection;

final class MemoryTableBuilder
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function run()
    {
         $this->connection->statement('CREATE TABLE IF NOT EXISTS todo_list_memory ENGINE=MEMORY as select 1');
         $this->connection->statement('DROP TABLE IF EXISTS todo_list_memory_temp');
         $this->connection->statement('
            CREATE TABLE todo_list_memory_temp ENGINE=MEMORY AS
            select
              `sales_activities`.*,
              `account`.`name` as account_name,
              `account`.`website` as account_website,
              `account`.`phone` as account_phone,
              `project`.`name` as project_name,
              `project`.`user_id` as user_id,
              `state`.`name` as state,
              `appointment`.`date` as appointment_date,
              `appointment`.`time` as appointment_time,
              `appointment`.`id` as appointment_id,
              `sales_activities`.`id` as activity_id
            from `sales_activities`
              inner join `sales_appointments` as `appointment_first` on `appointment_first`.`activity_id` = `sales_activities`.`id`
              inner join `sales_projects` as `project` on `project`.`id` = `sales_activities`.`project_id`
              inner join `sales_states` as `state` on `state`.`id` = `sales_activities`.`status_id`
              inner join `sales_accounts` as `account` on `account`.`id` = `sales_activities`.`account_id`
              inner join `sales_appointments` as `appointment` on `appointment`.`activity_id` = `sales_activities`.`id`
            where `appointment`.`done` = 0
              and `sales_activities`.`completed` = 0
            order by
              `appointment`.`date` asc,
              ISNULL(`appointment`.`time`) asc,
              `appointment`.`time` asc;');
         $this->connection->statement('RENAME TABLE `todo_list_memory` TO `todo_list_memory_old`, `todo_list_memory_temp` TO `todo_list_memory`');
         $this->connection->statement('DROP TABLE IF EXISTS `todo_list_memory_old`');
    }
}
