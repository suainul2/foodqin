<?php

use App\Http\Controllers\Api\OrderController;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Route::middleware([])->group(function () {
    Route::get("/ss",function(){
        return response()->json(InvoiceDetail::first());
    });
    Route::get('/order',[OrderController::class,"order"]);
});
