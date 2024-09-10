<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Subdistrict;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    private function generateRandomCoordinate($latitude, $longitude, $radiusInKm)
    {
        $radiusInDegrees = $radiusInKm / 111;

        $angle = mt_rand(0, 360);
        $distance = mt_rand(0, 10000) / 10000 * $radiusInDegrees;


        $angleRad = deg2rad($angle);

        // Menghitung koordinat baru
        $newLatitude = $latitude + ($distance * cos($angleRad));
        $newLongitude = $longitude + ($distance * sin($angleRad)) / cos(deg2rad($latitude));

        return [
            $newLatitude,
            $newLongitude
        ];
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();
        $subdistrict = Subdistrict::select("id", "city_id")->get()->groupBy("city_id")->toArray();
        $cities = City::get();
        $userStore = [];
        $pass = bcrypt("s");
        foreach ($cities as $city) {
            for ($i = 0; $i < 50; $i++) {
                $loc = $this->generateRandomCoordinate($city->latitude, $city->longitude, 7);
                $k = array_rand($subdistrict[$city->id]);
                $v = $subdistrict[$city->id][$k];
                $user = User::factory(1)->raw([
                    "subdistrict_id" => $v["id"],
                    "password" => $pass,
                    "role" => User::ROLE_CUSTOMER,
                    "latitude" => $loc[0],
                    "longitude" => $loc[1],
                ]);
                $userStore[] = $user[0];
            }
            for ($i = 0; $i < 50; $i++) {
                $loc = $this->generateRandomCoordinate($city->latitude, $city->longitude, 7);
                $k = array_rand($subdistrict[$city->id]);
                $v = $subdistrict[$city->id][$k];
                $user = User::factory(1)->raw([
                    "subdistrict_id" => $v["id"],
                    "password" => $pass,
                    "role" => User::ROLE_SELLER,
                    "latitude" => $loc[0],
                    "longitude" => $loc[1],
                ]);
                $userStore[] = $user[0];
            }
            for ($i = 0; $i < 30; $i++) {
                $loc = $this->generateRandomCoordinate($city->latitude, $city->longitude, 7);
                $k = array_rand($subdistrict[$city->id]);
                $v = $subdistrict[$city->id][$k];
                $user = User::factory(1)->raw([
                    "subdistrict_id" => $v["id"],
                    "password" => $pass,
                    "role" => User::ROLE_DRIVER,
                    "latitude" => $loc[0],
                    "longitude" => $loc[1],
                ]);
                $userStore[] = $user[0];
            }
        }
        $chunk_users = array_chunk($userStore, 993);
        foreach ($chunk_users as $chunk_user) {
            User::insert($chunk_user);
        }
    }
}
