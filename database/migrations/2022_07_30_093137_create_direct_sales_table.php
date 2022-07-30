<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direct_sales', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('customer_name')->nullable();
            $table->float('amount');
            $table->float('discount');
            $table->float('cash');
            $table->float('change');
            $table->integer('total_item');
            $table->foreignId('created_by_id');
            $table->foreignId('edit_by_id');
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
        Schema::dropIfExists('direct_sales');
    }
}
