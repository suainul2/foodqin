<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Province::truncate();
        $data_province = json_decode(file_get_contents(storage_path("location/provinces.json")),true);
        $provinces = [];
        foreach ($data_province as $province) {
            $provinces[] = [
                "id" => $province["id"],
                "name" => $province["name"],
                "created_at" => now(),
                "updated_at" => now() 
            ];
        }
        Province::insert($provinces);
    }
}
