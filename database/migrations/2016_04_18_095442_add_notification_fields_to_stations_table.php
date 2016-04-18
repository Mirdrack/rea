<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNotificationFieldsToStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stations', function (Blueprint $table) {
            
            $table->text('notification_phones');
            $table->text('notification_emails');
            $table->text('notification_subject');
            $table->text('notification_text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stations', function (Blueprint $table) {

            $table->dropColumn('notification_phones');
            $table->dropColumn('notification_emails');
            $table->dropColumn('notification_subject');
            $table->dropColumn('notification_text');            
        });
    }
}
