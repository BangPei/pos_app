<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_histories', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date')->nullable();
            $table->string('trans_code')->nullable();
            $table->integer('qty')->default(1);
            $table->integer('old_qty')->default(0);
            $table->foreignId('stock_id')->nullable();
            $table->integer('type'); //1- adding with new qty, -1 minus with new qty, 0 manual
            $table->string('note')->nullable();
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
        Schema::dropIfExists('stock_histories');
    }
}
