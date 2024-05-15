<?php

use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    // Get all the featured products
    $featuredProducts = Product::with('subCategory')
        ->where('featured', 1)
        ->whereHas('subCategory', function ($query) {
            $query->where('status', 1);
        })
        ->where('status', 1)
        ->orderByDesc('featured')
        ->orderByDesc('trending')
        ->orderByDesc('created_at')
        ->limit(6)
        ->get();

    return view('index', ['featuredProducts' => $featuredProducts]);
});
