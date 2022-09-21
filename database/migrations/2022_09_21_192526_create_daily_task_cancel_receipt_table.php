<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyTaskCancelReceiptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_task_cancel_receipt', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('daily_task_id');
            $table->foreign('daily_task_id')->references('id')->on('daily_tasks');
            $table->unsignedInteger('cancel_id');
            $table->foreign('cancel_id')->references('id')->on('cancel_receipts');
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
        Schema::dropIfExists('daily_task_cancel_receipt');
    }
}
