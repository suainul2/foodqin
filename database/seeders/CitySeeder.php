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
        $data_city = $this->getDataCity();
        $cities = [];
        foreach ($data_city as $city) {
            $cities[] = [
                "id" => $city[0],
                "name" => $city[2],
                "province_id" => $city[1],
                "latitude" => $city[3],
                "longitude" => $city[4],
                "type" => (str_contains(strtolower($city[2]), "kabupaten") ? 1 : 2),
                "created_at" => now(),
                "updated_at" => now(),
            ];
        }
        City::insert($cities);
    }
    function getDataCity()
    {
        // Nama file CSV
        $filename = storage_path("location/cities.csv");
        $dat = [];
        // Membuka file CSV
        if (($handle = fopen($filename, 'r')) !== FALSE) {
            $i = 0;
            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                // $data adalah array yang berisi setiap kolom dari baris CSV
                if($i > 0){
                    $dat[] = $data;
                }
                $i+=1;
            }
            // Menutup file setelah selesai
            fclose($handle);
        } else {
            echo "Tidak dapat membuka file $filename.";
        }
        return $dat;
    }
}
