<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function renderProduct($productSlug)
    {
        // Get specific product
        $product = Product::where('slug', $productSlug)
            ->where('status', 1)
            ->first();

        return view('product-view', ['product' => $product, 'subcategories' => $this->getAllSubcategories()]);
    }

    // Get all active subcategories
    private function getAllSubcategories()
    {
        return SubCategory::where('status', 1)->get();
    }
}
