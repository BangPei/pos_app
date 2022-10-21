<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlineOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_orders', function (Blueprint $table) {
            $table->id();
            $table->string("branch_number");
            $table->string("created_at_order");
            $table->string("updated_at_order");
            $table->string("delivery_info");
            $table->string("extra_attributes");
            $table->string("gift_message");
            $table->boolean("gift_option")->default(false);
            $table->integer("items_count");
            $table->string("national_registration_number");
            $table->integer("order_id");
            $table->integer("order_number");
            $table->string("payment_method");
            $table->float("price");
            $table->string("promised_shipping_times");
            $table->string("remarks");
            $table->string("shipment_provider");
            $table->float("shipping_fee");
            $table->float("shipping_fee_discount_platform");
            $table->float("shipping_fee_discount_seller");
            $table->float("shipping_fee_original");
            $table->float("shipping_provider_type");
            $table->string("statuses");
            $table->string("tax_code");
            $table->string("tracking_number")->unique();
            $table->float("voucher");
            $table->string("voucher_code");
            $table->float("voucher_platform");
            $table->float("voucher_seller");
            $table->float("dropshipping");
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
        Schema::dropIfExists('online_orders');
    }
}
