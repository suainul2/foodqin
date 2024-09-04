<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Subdistrict;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class SubdistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subdistrict::truncate();
        $cities = City::get();
        $subdistricts = [];
        foreach ($cities as $city) {
            $data_subdistrict = json_decode(file_get_contents(storage_path("location/districts/{$city->id}.json")),true);
            foreach ($data_subdistrict as $subdistrict) {
                $subdistricts[] = [
                    "id" => $subdistrict["id"],
                    "name" => $subdistrict["name"],
                    "city_id" => $city->id,
                    "created_at" => now(),
                    "updated_at" => now() 
                ];
            }
        }
        Subdistrict::insert($subdistricts);
    }
}
