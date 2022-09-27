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
            "description" => "Lazada",
            "alias" => "LEX"
        ]);
        Expedition::create([
            "name" => "Shopee Express",
            "description" => "Shopee",
            "alias" => "SHOPEE"
        ]);
        Expedition::create([
            "name" => "JNE Reguler",
            "description" => "Shopee, Tokopedia",
            "alias" => "JNE"
        ]);
        Expedition::create([
            "name" => "JNE Coorporation",
            "description" => "Blibli, Lazada",
            "alias" => "COOR"
        ]);
        Expedition::create([
            "name" => "Ninja Express",
            "description" => "Blibli, Lazada, Tokopedia",
            "alias" => "NINJA"
        ]);
        Expedition::create([
            "name" => "AntarAja",
            "description" => "Blibli, Tokopedia, Shopee",
            "alias" => "ANTARAJA"
        ]);
        Expedition::create([
            "name" => "JX",
            "description" => "JD ID",
            "alias" => "JX"
        ]);
        Expedition::create([
            "name" => "SameDay",
            "description" => "Lazada, Shopee, Tokopedia, Blibli, JD ID",
            "alias" => "SAMEDAY"
        ]);
        Expedition::create([
            "name" => "Instant",
            "description" => "Lazada, Shopee, Tokopedia, Blibli, JD ID",
            "alias" => "INSTANT"
        ]);
        Expedition::create([
            "name" => "Shopee Instant",
            "description" => "Shopee",
            "alias" => "SH_INSTANT"
        ]);
    }
}
