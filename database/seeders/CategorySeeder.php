<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            "name" => "Makanan dan Minuman",
            "description" => "Katagori untuk makanan dan minuman",
            "is_active" => true,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
        Category::create([
            "name" => "Susu Formula",
            "description" => "Katagori untuk susu formula",
            "is_active" => true,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
        Category::create([
            "name" => "Ibu dan Bayi",
            "description" => "Katagori untuk Ibu dan Bayi",
            "is_active" => true,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
        Category::create([
            "name" => "Perawatan Tubuh",
            "description" => "Katagori untuk perawatan tubuh",
            "is_active" => true,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);

        Category::create([
            "name" => "Perawatan Rumah",
            "description" => "Katagori untuk perawatan rumah",
            "is_active" => true,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
        Category::create([
            "name" => "Rokok",
            "description" => "Katagori untuk rokok",
            "is_active" => true,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
    }
}
