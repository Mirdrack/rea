<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStationSensorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('station_sensors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('station_id')->unsigned();
            $table->string('name');
            $table->string('label');
            $table->boolean('alarm_activated')->default(false);
            $table->integer('alarm_cooldown')->unsigned();
            $table->dateTime('alarm_turned_off_at')->nullable();
            $table->text('notification_emails');
            $table->text('notification_subject');
            $table->text('notification_text');
            $table->timestamps();

            $table->foreign('station_id')
                  ->references('id')
                  ->on('stations')
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
        Schema::drop('station_sensors');
    }
}
