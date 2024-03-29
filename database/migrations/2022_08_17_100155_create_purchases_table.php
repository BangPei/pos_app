<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('invoice_no')->nullable();
            $table->string('pic')->nullable();
            $table->foreignId('created_by_id');
            $table->foreignId('edit_by_id');
            $table->foreignId('supplier_id');
            $table->float('amount');
            $table->float('subtotal');
            $table->float('discount');
            $table->float('dpp');
            $table->float('tax_paid');
            $table->integer('total_item');
            $table->integer('tax');
            $table->timestamp('date_time');
            $table->timestamp('due_date')->nullable();
            $table->enum('payment_type', ['lunas', 'tempo']);
            $table->binary('picture')->nullable();
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
        Schema::dropIfExists('purchases');
    }
}
