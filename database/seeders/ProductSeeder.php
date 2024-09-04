<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    private function getProductCategoryIdRandom() {
        $productCategory =  ProductCategory::inRandomOrder()
        ->first();
        return $productCategory->id;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where("role",User::ROLE_SELLER)
        ->get();
        foreach ($users as $user) {
           Product::create([
                "user_id" => $user->id,
                "product_category_id" => $this->getProductCategoryIdRandom(),
                "name" => fake()->name(),
                "price" => rand(10000,1000000),
                "desc" => fake()->text(100), 
           ]);
        }
    }
}
