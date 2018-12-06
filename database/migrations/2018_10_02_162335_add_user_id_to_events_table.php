<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdToEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::table('events', function (Blueprint $table) {
           $table->integer('user_id')->unsigned()->nullable()->after('volunteers');
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::table('events', function (Blueprint $table) {
             $table->dropColumn('user_id');
         });
     }
}