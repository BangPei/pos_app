<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyTaskDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_task_details', function (Blueprint $table) {
            $table->id();
            // $table->unsignedInteger('daily_tasks_id');
            $table->foreignId('daily_tasks_id')->references('id')->on('daily_tasks');
            // $table->unsignedInteger('expedition_id');
            $table->foreignId('expedition_id')->references('id')->on('expeditions');
            $table->integer('total');
            $table->string('data')->nullable();
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
        Schema::dropIfExists('daily_task_details');
    }
}
