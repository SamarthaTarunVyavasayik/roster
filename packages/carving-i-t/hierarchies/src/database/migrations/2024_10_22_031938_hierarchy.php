<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Hierarchy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('positions', function(Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->integer('reports_to')->nullable();
            $table->timestamps();

            $table->unique(['label', 'reports_to']);
        });

        Schema::create('position_users', function(Blueprint $table) {
            $table->id();
            $table->bigInteger('position_id');
            $table->bigInteger('user_id');
            $table->text('attributes')->nullable();
            $table->unique(['user_id', 'position_id']);
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
        Schema::dropIfExists('positions');
        Schema::dropIfExists('position_users');
    }
}

