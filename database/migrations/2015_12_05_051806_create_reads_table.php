<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('station_reads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('station_id')->unsigned();
            $table->decimal('dynamic_level', 6, 2);
            $table->decimal('voltage', 6, 2);
            $table->decimal('current', 6, 2);
            $table->decimal('power', 6, 2);
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
        Schema::drop('station_reads');
    }
}
