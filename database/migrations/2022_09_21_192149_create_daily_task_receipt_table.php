<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyTaskReceiptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_task_receipt', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('daily_task_id');
            $table->foreign('daily_task_id')->references('id')->on('daily_tasks');
            $table->unsignedInteger('receipt_id');
            $table->foreign('receipt_id')->references('id')->on('receipts');
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
        Schema::dropIfExists('daily_task_receipt');
    }
}
