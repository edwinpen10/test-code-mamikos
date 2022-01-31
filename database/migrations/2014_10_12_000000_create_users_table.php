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
            $table->id();
            $table->string('name');
            $table->char('number_phone',15)->unique();
            $table->string('email')->unique()->nullable();
            $table->enum('user_type', ['regular', 'premium'])->nullable();
            $table->string('password');
            $table->string('refresh_token')->nullable();
            $table->string('exp_refresh_token')->nullable();
            $table->integer('credit_user');
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
