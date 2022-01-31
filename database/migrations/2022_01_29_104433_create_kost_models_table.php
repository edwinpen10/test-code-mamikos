<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKostModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kost_models', function (Blueprint $table) {
            $table->id();
            $table->integer('id_owner');
            $table->string('title_kost');
            $table->string('slug_title')->nullable();
            $table->enum('gender', [1, 2, 3]);
            $table->string('province');
            $table->string('city');
            $table->string('address');
            $table->string('description');
            $table->integer('building_year');
            $table->integer('price');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kost_models');
    }
}
