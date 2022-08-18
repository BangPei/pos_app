<?php

namespace Database\Seeders;

use App\Models\Atm;
use Illuminate\Database\Seeder;

class AtmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Atm::create([
            "name" => "BCA",
            "description" => "Pembayaran Dengan ATM BCA",
            "is_active" => true,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
        Atm::create([
            "name" => "Mandiri",
            "description" => "Pembayaran Dengan ATM Mandiri",
            "is_active" => true,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
    }
}
