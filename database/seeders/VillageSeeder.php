<?php

namespace Database\Seeders;

use App\Models\Subdistrict;
use App\Models\Village;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Village::truncate();
        $subdistricts = Subdistrict::get();
        $villages = [];
        foreach ($subdistricts as $subdistrict) {
            $data_village = json_decode(file_get_contents(storage_path("location/villages/{$subdistrict->id}.json")),true);
            foreach ($data_village as $village) {
                $villages[] = [
                    "name" => $village["name"],
                    "subdistrict_id" => $subdistrict->id,
                    "created_at" => now(),
                    "updated_at" => now() 
                ];
            }
        }
        $chunk_villages = array_chunk($villages, 993);
        foreach ($chunk_villages as $chunk_village) {
            Village::insert($chunk_village);
        }
    }
}
