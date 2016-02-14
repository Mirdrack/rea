<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('station_alarms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('station_id')->unsigned();
            $table->integer('alarm_id')->unsigned();
            $table->dateTime('created_at');

            $table->foreign('station_id')
                  ->references('id')
                  ->on('stations')
                  ->onDelete('cascade');

            $table->foreign('alarm_id')
                  ->references('id')
                  ->on('alarms')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('station_alarms');
    }
}
