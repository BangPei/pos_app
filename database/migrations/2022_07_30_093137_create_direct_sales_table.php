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
            $table->decimal('amount', 10, 2);
            $table->float('discount');
            $table->float('additional_discount');
            $table->decimal('cash', 10, 2);
            $table->float('change');
            $table->decimal('subtotal', 10, 2);
            $table->integer('reduce');
            $table->integer('total_item');
            $table->foreignId('payment_type_id');
            $table->foreignId('created_by_id');
            $table->foreignId('edit_by_id');
            $table->foreignId('bank_id')->nullable();
            $table->boolean('is_cash');
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
