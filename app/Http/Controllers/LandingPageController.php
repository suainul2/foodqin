<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    function index() {
        $categories = ProductCategory::orderBy("name")->get();
        $products = Product::with("category")->orderByDesc("created_at")->get();
        return view("landing_page",compact("categories","products"));
    }
}
