<?php

use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;

// START OF CLIENT SIDE

// Home Route
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

    // Get the latest/newest products
    $newProducts = Product::with('subCategory')
        ->whereHas('subCategory', function ($query) {
            $query->where('status', 1);
        })
        ->where('status', 1)
        ->orderByDesc('featured')
        ->orderByDesc('trending')
        ->orderByDesc('created_at')
        ->limit(4)
        ->get();

    // Get all active subcategories
    $subcategories = SubCategory::where('status', 1)->get();

    return view('index', [
        'featuredProducts' => $featuredProducts,
        'newProducts' => $newProducts,
        'subcategories' => $subcategories
    ]);
});


// Categories Route
Route::prefix('categories')->group(function () {
    Route::get('/new-arrivals', [CategoryController::class, 'showNewArrivals'])->name('new-arrivals');
    Route::get('/featured-shoes', [CategoryController::class, 'showFeaturedShoes'])->name('featured-shoes');
    Route::get('/men-shoes/subcategories/{subcategory}', [CategoryController::class, 'showMenShoes'])->name('men-shoes');
    Route::get('/women-shoes/subcategories/{subcategory}', [CategoryController::class, 'showWomenShoes'])->name('women-shoes');
    Route::get('/kid-shoes/subcategories/{subcategory}', [CategoryController::class, 'showKidShoes'])->name('kid-shoes');
});

// Users Route
Route::get('/sign-in', [UserController::class, 'renderSignIn'])->name('sign-in.render');
Route::get('/sign-up', [UserController::class, 'renderSignUp'])->name('sign-up.render');
Route::post('/register', [UserController::class, 'register'])->name('user.register');
Route::post('/sign-in', [UserController::class, 'signIn'])->name('user.signIn');
Route::post('/sign-out', [UserController::class, 'signOut'])->name('user.signOut');

// END OF CLIENT SIDE

// START OF ADMIN SIDE

// END OF ADMIN SIDE
