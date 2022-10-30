<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('level_id')->references('id')->on('levels')->onUpdateCascade()->onDeleteCascade();
        });
    }

   
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
