<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        City::truncate();
        $provinces = Province::get();
        $cities = [];
        foreach ($provinces as $province) {
            $data_city = json_decode(file_get_contents(storage_path("location/regencies/{$province->id}.json")),true);
            foreach ($data_city as $city) {
                $cities[] = [
                    "id" => $city["id"],
                    "name" => $city["name"],
                    "province_id" => $province->id,
                    "created_at" => now(),
                    "updated_at" => now() 
                ];
            }
        }
        City::insert($cities);
    }
}
