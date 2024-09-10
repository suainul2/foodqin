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
        $data_province = $this->getDataProvince();
        $provinces = [];
        foreach ($data_province as $province) {
            $provinces[] = [
                "id" => $province[0],
                "name" => $province[2],
                "created_at" => now(),
                "updated_at" => now() 
            ];
        }
        Province::insert($provinces);
    }
    function getDataProvince(){
        // Nama file CSV
        $filename = storage_path("location/provinces.csv");
        $dat = [];
        // Membuka file CSV
        if (($handle = fopen($filename, 'r')) !== FALSE) {
            // Membaca setiap baris dalam file CSV
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
