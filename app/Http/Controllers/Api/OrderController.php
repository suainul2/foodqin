<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    const SHIPPING_COST_KM = 1000;
    private function getUserByDistance($latitude, $longitude, $radius, $role)
    {
        return User::select('users.*', DB::raw("(
        6371 * acos(
            cos(radians($latitude)) 
            * cos(radians(latitude)) 
            * cos(radians(longitude) - radians($longitude)) 
            + sin(radians($latitude)) 
            * sin(radians(latitude))
        )
    ) AS distance"))
            ->having('distance', '<', $radius)
            ->where("role", $role)
            ->inRandomOrder()
            ->first();
    }
    private function calculateShippingCost($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
    {
        $earthRadius = 6371;
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);


        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;


        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos($latFrom) * cos($latTo) *
            sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));


        $distance = $earthRadius * $c;

        return ($distance*self::SHIPPING_COST_KM);
    }
    function order()
    {
        $customer = User::where("role", User::ROLE_CUSTOMER)->inRandomOrder()->first();
        $customer_latitude = $customer->latitude;
        $customer_longitude = $customer->longitude;
        $radius = 7;
        $seller = $this->getUserByDistance($customer_latitude, $customer_longitude, $radius, User::ROLE_SELLER);

        $seller_latitude = $seller->latitude;
        $seller_longitude = $seller->longitude;
        $driver = $this->getUserByDistance($seller_latitude, $seller_longitude, $radius, User::ROLE_DRIVER);
        $product = Product::where("user_id", $seller->id)
            ->inRandomOrder()
            ->first();
        $invoice = Invoice::create([
            "user_id" => $customer->id,
            "driver_id" => $driver->id,
            "code" => rand(1000, 100000),
            "shipping_cost" => $this->calculateShippingCost($seller_latitude,$seller_longitude,$customer_latitude,$customer_longitude),
            "from_latitude" => $seller_latitude,
            "from_longitude" => $seller_longitude,
            "to_latitude" => $customer_latitude,
            "to_longitude" => $customer_longitude,
            "address" => $customer->address,
            "status" => Invoice::STATUS_FINISH,
        ]);
        InvoiceDetail::create([
            "invoice_id" => $invoice->id,
            "product_id" => $product->id,
            "price" => $product->price,
            "qty" => 1,
        ]);
        $invoice->load("details");
        return response()->json([
            "status" => "success",
            "code" => 200,
            "data" => $invoice,
        ]);
    }
}
