<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductCategory::truncate();
        $categories = [
            "Makanan",
            "Minuman",
            "Kue",
            "Buah-buahan"
        ];
        foreach ($categories as $category) {
            ProductCategory::create([
                "name" => $category
            ]);
        }
    }
}
