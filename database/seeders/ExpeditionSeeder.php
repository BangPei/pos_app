<?php

namespace Database\Seeders;

use App\Models\Expedition;
use Illuminate\Database\Seeder;

class ExpeditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Expedition::create([
            "name" => "LEX",
            "description" => "Lazada"
        ]);
        Expedition::create([
            "name" => "Shopee Express",
            "description" => "Shopee"
        ]);
        Expedition::create([
            "name" => "JNE Reguler",
            "description" => "Shopee, Tokopedia"
        ]);
        Expedition::create([
            "name" => "JNE Coorporation",
            "description" => "Blibli, Lazada"
        ]);
        Expedition::create([
            "name" => "Ninja Express",
            "description" => "Blibli, Lazada, Tokopedia"
        ]);
        Expedition::create([
            "name" => "AntarAja",
            "description" => "Blibli, Tokopedia, Shopee"
        ]);
        Expedition::create([
            "name" => "JX",
            "description" => "JD ID"
        ]);
        Expedition::create([
            "name" => "SameDay",
            "description" => "Lazada, Shopee, Tokopedia, Blibli, JD ID"
        ]);
        Expedition::create([
            "name" => "Instant",
            "description" => "Lazada, Shopee, Tokopedia, Blibli, JD ID"
        ]);
        Expedition::create([
            "name" => "Shopee Instant",
            "description" => "Shopee"
        ]);
    }
}
