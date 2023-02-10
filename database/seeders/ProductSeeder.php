<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            "name" => "Sasa Saus Tomat 8 gr",
            "is_active" => true,
            "category_id" => 1,
            "created_by_id" => 2,
            "edit_by_id" => 2,
        ]);
        Product::create([
            "name" => "Caladine cream 15 gr",
            "is_active" => true,
            "category_id" => 4,
            "created_by_id" => 2,
            "edit_by_id" => 2,
        ]);
        Product::create([
            "name" => "Cussons Baby Cologne Soft Touch 100 ml",
            "is_active" => true,
            "category_id" => 3,
            "created_by_id" => 2,
            "edit_by_id" => 2,
        ]);
        Product::create([
            "name" => "Marlboro Black 20 btg",
            "is_active" => true,
            "category_id" => 6,
            "created_by_id" => 2,
            "edit_by_id" => 2,
        ]);
        Product::create([
            "name" => "Shinzui Sakura 420 ml",
            "is_active" => true,
            "category_id" => 4,
            "created_by_id" => 2,
            "edit_by_id" => 2,
        ]);
        Product::create([
            "name" => "Carex Sabun Cuci Tangan Aloe Vera 200 ml",
            "is_active" => true,
            "category_id" => 4,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
        Product::create([
            "name" => "Prenagen Lactamom Stroberi 200 gr",
            "is_active" => true,
            "category_id" => 2,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
        Product::create([
            "name" => "Laurier Relax Night 30cm 16pcs",
            "is_active" => true,
            "category_id" => 4,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
        Product::create([
            "name" => "Chil go 3+ Vanilla 700 gr",
            "is_active" => true,
            "category_id" => 2,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
        Product::create([
            "name" => "Chil go 3+ Madu 700 gr",
            "is_active" => true,
            "category_id" => 2,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
        Product::create([
            "name" => "Chil go 1+ Madu 700 gr",
            "is_active" => true,
            "category_id" => 2,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
        Product::create([
            "name" => "Chil go 1+ Vanilla 700 gr",
            "is_active" => true,
            "category_id" => 2,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
    }
}
