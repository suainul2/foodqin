<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where("role", User::ROLE_SELLER)
            ->get();
        $products = [];
        $productCategory =  ProductCategory::get()->toArray();
        foreach ($users as $user) {
            $k = array_rand($productCategory);
            $v = $productCategory[$k];
            $products[] = [
                "user_id" => $user->id,
                "product_category_id" => $v["id"],
                "name" => fake()->name(),
                "price" => rand(10000, 1000000),
                "desc" => fake()->text(100),
            ];
        }
        $chunk_products = array_chunk($products, 993);
        foreach ($chunk_products as $chunk_product) {
            Product::insert($chunk_product);
        }
    }
}
