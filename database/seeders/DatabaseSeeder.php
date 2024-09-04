<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->call(ProvinceSeeder::class);
        // $this->call(CitySeeder::class);
        // $this->call(SubdistrictSeeder::class);
        // $this->call(VillageSeeder::class);
        $this->call(ProductCategorySeeder::class);
        $this->call(UserSeeder::class);
    }
}
