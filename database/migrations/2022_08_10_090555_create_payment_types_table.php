<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description');
            $table->boolean('is_active')->default(true);
            $table->boolean('paid_off')->default(true);
            $table->boolean('is_default')->default(false);
            $table->boolean('reduce_option')->default(false);
            $table->boolean('show_atm')->default(false);
            $table->boolean('show_cash')->default(false);
            $table->foreignId('created_by_id');
            $table->foreignId('edit_by_id');
            $table->foreignId('reduce_id')->nullable();
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
        Schema::dropIfExists('payment_types');
    }
}
