<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->index('id');
            $table->string('first_name',500);
            $table->string('last_name',500);
            $table->string('email',500);
            $table->string('username',255);
            $table->string('password',255);
            $table->string('phone_number',50);
            $table->string('profile_image',500);
            $table->enum('gender', ['Male', 'Female']);
            $table->date('date_of_birth');
            $table->dateTime('register_time');
            $table->string('verification_code',255);
            $table->string('remember_token',255);
            $table->enum('user_type', ['Admin', 'User'])->default('User');
            $table->enum('login_status', ['Online', 'Offline'])->default('Offline');
            $table->enum('status',['Active', 'Inactive'])->default('Inactive');
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
