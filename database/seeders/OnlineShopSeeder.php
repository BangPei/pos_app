<?php

namespace Database\Seeders;

use App\Models\OnlineShop;
use Illuminate\Database\Seeder;

class OnlineShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OnlineShop::create([
            "name" => "Shopee",
        ]);
        OnlineShop::create([
            "name" => "Lazada",
        ]);
        OnlineShop::create([
            "name" => "Blibli",
        ]);
        OnlineShop::create([
            "name" => "Tokopedia",
        ]);
        OnlineShop::create([
            "name" => "JD.ID",
        ]);
    }
}
