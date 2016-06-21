<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TodoListGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'todo:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \DB::statement('CREATE TABLE IF NOT EXISTS todo_list_memory ENGINE=MEMORY as select 1');
        \DB::statement('DROP TABLE IF EXISTS todo_list_memory_temp');
        \DB::statement('
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
              `appointment`.`time` as appointment_time
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
        \DB::statement('RENAME TABLE `todo_list_memory` TO `todo_list_memory_old`, `todo_list_memory_temp` TO `todo_list_memory`');
        \DB::statement('DROP TABLE IF EXISTS `todo_list_memory_old`');
    }
}
