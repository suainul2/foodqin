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
        $subdistricts = [];
            $data_subdistrict =$this->getDataSubdistrict();
            foreach ($data_subdistrict as $subdistrict) {
                $subdistricts[] = [
                    "id" => $subdistrict[0],
                    "name" => $subdistrict[2],
                    "city_id" => $subdistrict[1],
                    "created_at" => now(),
                    "updated_at" => now() 
                ];
            }
        Subdistrict::insert($subdistricts);
    }
    function getDataSubdistrict()
    {
        // Nama file CSV
        $filename = storage_path("location/subdistricts.csv");
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
