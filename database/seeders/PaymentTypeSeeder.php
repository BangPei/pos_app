<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentType::create([
            "name" => "Debit",
            "description" => "Tipe Pembayaran Dengan Debit",
            "is_active" => true,
            "is_default" => false,
            "created_by_id" => 1,
            "edit_by_id" => 1,
            "reduce_id" => 1,
            "reduce_option" => true,
            "show_atm" => true,
            "show_cash" => false,
            "paid_off" => true,
        ]);
        PaymentType::create([
            "name" => "Kartu Kredit",
            "description" => "Tipe Pembayaran Dengan Kartu Kredit",
            "is_active" => true,
            "is_default" => false,
            "created_by_id" => 1,
            "edit_by_id" => 1,
            "reduce_id" => 2,
            "reduce_option" => false,
            "show_atm" => false,
            "show_cash" => false,
            "paid_off" => true,
        ]);
        PaymentType::create([
            "name" => "Tunai",
            "description" => "Tipe Pembayaran Dengan Tunai",
            "is_active" => true,
            "is_default" => true,
            "created_by_id" => 1,
            "edit_by_id" => 1,
            "reduce_option" => false,
            "show_atm" => false,
            "show_cash" => true,
            "paid_off" => true,
        ]);
        PaymentType::create([
            "name" => "Transfer",
            "description" => "Tipe Pembayaran Dengan Transfer",
            "is_active" => true,
            "is_default" => false,
            "created_by_id" => 1,
            "edit_by_id" => 1,
            "reduce_option" => false,
            "show_atm" => false,
            "show_cash" => false,
            "paid_off" => true,
        ]);
        PaymentType::create([
            "name" => "E-money",
            "description" => "Tipe Pembayaran Dengan E-money",
            "is_active" => true,
            "is_default" => false,
            "created_by_id" => 1,
            "edit_by_id" => 1,
            "reduce_option" => false,
            "show_atm" => false,
            "show_cash" => false,
            "paid_off" => true,
        ]);
        PaymentType::create([
            "name" => "Hutang",
            "description" => "Tipe Pembayaran Dengan Hutang",
            "is_active" => true,
            "is_default" => false,
            "created_by_id" => 1,
            "edit_by_id" => 1,
            "reduce_option" => false,
            "show_atm" => false,
            "show_cash" => false,
            "paid_off" => false,
        ]);
    }
}
