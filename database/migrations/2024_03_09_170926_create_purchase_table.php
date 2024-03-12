<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function GuzzleHttp\default_ca_bundle;

class CreatePurchaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('invoice_no')->unique()->nullable();
            $table->decimal('dpp', 10, 2)->default(0);
            $table->decimal('discount_extra', 10, 2)->default(0);
            $table->timestamp('date');
            $table->timestamp('due_date')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->boolean('is_distributor')->default(false);
            $table->boolean('status')->default(false);
            $table->enum('payment_type', ['lunas', 'tempo']);
            $table->string('pic')->nullable();
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->foreignId('supplier_id')->nullable();
            $table->integer('tax')->default(0);
            $table->boolean('tax_in_price')->default(false);
            $table->decimal('tax_paid', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);
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
        Schema::dropIfExists('purchase');
    }
}
