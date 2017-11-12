<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fname');
            $table->string('lname');
            $table->string('email')->unique();
            $table->integer('phone')->unique();
            $table->string('password');
            $table->integer('group_id')->unsigned();
            $table->string('admin_email');
            $table->foreign('group_id')->references('id')->on('saccosGroups')
            ->onUpdate('cascade')->onDelete('cascade');
           
            $table->foreign('admin_email')->references('admin_email')->on('saccosGroups')
            ->onUpdate('cascade')->onDelete('cascade');
            

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}