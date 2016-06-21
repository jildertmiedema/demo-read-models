<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSalesActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_activities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('status_id')->unsigned()->index();
            $table->foreign('status_id')->references('id')->on('sales_states')->onDelete('restrict');
            $table->integer('account_id')->unsigned()->index();
            $table->foreign('account_id')->references('id')->on('sales_accounts')->onDelete('restrict');
            $table->integer('project_id')->unsigned()->index();
            $table->foreign('project_id')->references('id')->on('sales_projects')->onDelete('restrict');
            $table->unique(['account_id', 'project_id']);
            $table->boolean('completed');
            $table->boolean('hasDeal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sales_activities');
    }
}
