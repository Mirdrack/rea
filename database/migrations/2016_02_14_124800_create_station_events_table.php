<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStationEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('station_events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('station_id')->unsigned();
            $table->integer('event_type_id')->unsigned();
            $table->string('ip_address', 45);
            $table->dateTime('created_at');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('station_id')
                  ->references('id')
                  ->on('stations')
                  ->onDelete('cascade');

            $table->foreign('event_type_id')
                  ->references('id')
                  ->on('event_types')
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
        Schema::drop('station_events');
    }
}
