<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTodoListView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
        CREATE VIEW todo_list AS
            select
              `sales_activities`.*,
              `account`.`name` as account_name,
              `account`.`website` as account_website,
              `account`.`phone` as account_phone,
              `project`.`name` as project_name,
              `project`.`user_id` as user_id,
              `user`.`name` as user_name,
              `state`.`name` as state,
              `appointment`.`date` as appointment_date,
              `appointment`.`time` as appointment_time
            from `sales_activities`
              inner join `sales_appointments` as `appointment_first` on `appointment_first`.`activity_id` = `sales_activities`.`id`
              inner join `sales_projects` as `project` on `project`.`id` = `sales_activities`.`project_id`
              inner join `sales_states` as `state` on `state`.`id` = `sales_activities`.`status_id`
              inner join `sales_accounts` as `account` on `account`.`id` = `sales_activities`.`account_id`
              inner join `sales_appointments` as `appointment` on `appointment`.`activity_id` = `sales_activities`.`id`
              inner join `users` as `user` on `project`.`user_id` = `user`.`id`
            where `appointment`.`done` = 0
              and `sales_activities`.`completed` = 0
            order by
              `appointment`.`date` asc,
              ISNULL(`appointment`.`time`) asc,
              `appointment`.`time` asc
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('drop VIEW todo_list;');
    }
}
