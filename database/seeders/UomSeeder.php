<?php

namespace Database\Seeders;

use App\Models\Uom;
use Illuminate\Database\Seeder;

class UomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Uom::create([
            "name" => "KG",
            "description" => "Kilogram",
            "is_active" => true,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
        Uom::create([
            "name" => "GR",
            "description" => "Gram",
            "is_active" => true,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
        Uom::create([
            "name" => "PCS",
            "description" => "Pieces",
            "is_active" => true,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
        Uom::create([
            "name" => "Box",
            "description" => "Box",
            "is_active" => true,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
        Uom::create([
            "name" => "Dus",
            "description" => "Karton",
            "is_active" => true,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
    }
}
