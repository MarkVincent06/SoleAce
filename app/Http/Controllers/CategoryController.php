<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class CategoryController extends Controller
{
    public function showNewArrivals()
    {
        $categoryName = "new";
        $categoryWebTitle = "New Arrivals";

        // Get the latest/newest products
        $newProducts = Product::with('subCategory')
            ->whereHas('subCategory', function ($query) {
                $query->where('status', 1);
            })
            ->where('status', 1)
            ->orderByDesc('featured')
            ->orderByDesc('trending')
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();

        return $this->renderCategoryView($categoryName, $categoryWebTitle, $newProducts);
    }

    public function showFeaturedShoes()
    {
        $categoryName = "featured";
        $categoryWebTitle = "Featured Shoes";

        // Get all the featured products
        $featuredShoes = Product::with('subCategory')
            ->where('featured', 1)
            ->whereHas('subCategory', function ($query) {
                $query->where('status', 1);
            })
            ->where('status', 1)
            ->orderByDesc('featured')
            ->orderByDesc('trending')
            ->orderByDesc('created_at')
            ->limit(20)
            ->get();

        return $this->renderCategoryView($categoryName, $categoryWebTitle, $featuredShoes);
    }

    public function showMenShoes($subcategory)
    {
        $subcategoryName = $subcategory;
        $categoryName = "men";
        $categoryWebTitle = $subcategoryName === "all" ? "All Shoes for Men" : 'Men\'s ' . ucfirst($subcategoryName) . ' Shoes';
        $catAndSubcatProducts = $this->getCatAndSubcatProducts($categoryName, $subcategoryName);

        return $this->renderCategoryView($categoryName, $categoryWebTitle, $catAndSubcatProducts, $subcategoryName);
    }

    public function showWomenShoes($subcategory)
    {
        $subcategoryName = $subcategory;
        $categoryName = "women";
        $categoryWebTitle = $subcategoryName === "all" ? "All Shoes for Women" : 'Women\'s ' . ucfirst($subcategoryName) . ' Shoes';
        $catAndSubcatProducts = $this->getCatAndSubcatProducts($categoryName, $subcategoryName);

        return $this->renderCategoryView($categoryName, $categoryWebTitle, $catAndSubcatProducts, $subcategoryName);
    }

    public function showKidShoes($subcategory)
    {
        $subcategoryName = $subcategory;
        $categoryName = "kid";
        $categoryWebTitle = $subcategoryName === "all" ? "All Shoes for Kids" : ucfirst($subcategoryName) . '\' Shoes';
        $catAndSubcatProducts = $this->getCatAndSubcatProducts($categoryName, $subcategoryName);

        return $this->renderCategoryView($categoryName, $categoryWebTitle, $catAndSubcatProducts, $subcategoryName);
    }

    // Get all active subcategories
    private function getAllSubcategories()
    {
        return SubCategory::where('status', 1)->get();
    }

    // Get all categorized and subcategorized products 
    private function getCatAndSubcatProducts($category, $subcategory)
    {
        return $query = Product::with('subCategory')
            ->whereHas('subCategory', function (Builder $query) use ($subcategory) {
                if ($subcategory !== 'all') {
                    $query->where('name', $subcategory);
                }
                $query->where('status', 1);
            })
            ->where('category', $category)
            ->where('status', 1)
            ->orderByDesc('created_at')
            ->get();
    }

    // Render the category view
    private function renderCategoryView($categoryName, $categoryWebTitle, $categorizedProducts, $subcategoryName = null)
    {
        return view('category', [
            'categoryName' => $categoryName,
            'categoryWebTitle' => $categoryWebTitle,
            'categorizedProducts' => $categorizedProducts,
            'subcategories' => $this->getAllSubcategories(),
            'subcategoryName' => $subcategoryName
        ]);
    }
}
