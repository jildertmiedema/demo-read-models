<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSalesAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('activity_id')->unsigned()->index();
            $table->foreign('activity_id')->references('id')->on('sales_activities')->onDelete('cascade');
            $table->time('time')->nullable();
            $table->date('date');
            $table->boolean('done')->default(false);
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
        Schema::drop('sales_appointments');
    }
}
