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
            "name" => "Bumbu Dapur",
            "description" => "Katagori untuk Bumbu Dapur",
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
            "name" => "Perawatan Bayi",
            "description" => "Katagori untuk perawatan Bayi",
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
            "name" => "Perawatan Rumah Tangga",
            "description" => "Katagori untuk perawatan rumah Tangga",
            "is_active" => true,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
        Category::create([
            "name" => "Obat",
            "description" => "Katagori untuk Obat",
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
        Category::create([
            "name" => "Kewanitaan",
            "description" => "Katagori untuk Kewanitaan",
            "is_active" => true,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
        Category::create([
            "name" => "Popok Bayi Dan Dewasa",
            "description" => "Katagori untuk Popok Bayi Dan Dewasa",
            "is_active" => true,
            "created_by_id" => 1,
            "edit_by_id" => 1,
        ]);
    }
}
