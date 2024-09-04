<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();
        User::factory(50)->create([
            "password" => bcrypt("c"),
            "role" => User::ROLE_CUSTOMER,
        ]);
        User::factory(50)->create([
            "password" => bcrypt("s"),
            "role" => User::ROLE_SELLER,
        ]);
        User::factory(30)->create([
            "password" => bcrypt("s"),
            "role" => User::ROLE_DRIVER,
        ]);
    }
}
