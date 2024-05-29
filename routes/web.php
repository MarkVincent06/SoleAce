<?php


use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MyOrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\ProductController as ClientProductController; // Alias for client ProductController
use App\Http\Controllers\Admin\ProductController as AdminProductController; // Alias for admin ProductController


Route::middleware('prevent.back.history')->group(function () {
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
    })->name('home');


    // Categories Route
    Route::prefix('categories')->group(function () {
        Route::get('/new-arrivals', [CategoryController::class, 'showNewArrivals'])->name('new-arrivals');
        Route::get('/featured-shoes', [CategoryController::class, 'showFeaturedShoes'])->name('featured-shoes');
        Route::get('/men-shoes/subcategories/{subcategory}', [CategoryController::class, 'showMenShoes'])->name('men-shoes');
        Route::get('/women-shoes/subcategories/{subcategory}', [CategoryController::class, 'showWomenShoes'])->name('women-shoes');
        Route::get('/kid-shoes/subcategories/{subcategory}', [CategoryController::class, 'showKidShoes'])->name('kid-shoes');
    });

    // Product View Route
    Route::get('/product-view/{productSlug}', [ClientProductController::class, 'renderProduct'])->name('product.render');

    // Users Route
    Route::get('/sign-in', [UserController::class, 'renderSignIn'])->name('sign-in.render');
    Route::get('/sign-up', [UserController::class, 'renderSignUp'])->name('sign-up.render');
    Route::post('/register', [UserController::class, 'register'])->name('user.register');
    Route::post('/sign-in', [UserController::class, 'signIn'])->name('user.signIn');
    Route::post('/sign-out', [UserController::class, 'signOut'])->name('user.signOut');

    // Carts Route
    Route::middleware('user.auth')->group(function () {
        Route::get('/cart', [CartController::class, 'renderCart'])->name('cart.render');
        Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');
        Route::post('/cart/{id}', [CartController::class, 'updateFromCart'])->name('cart.update');
        Route::delete('/cart/{id}', [CartController::class, 'deleteFromCart'])->name('cart.delete');
    });

    // Orders Route
    Route::get('/checkout', [OrderController::class, 'renderCheckout'])->name('order.renderCheckout');
    Route::post('/placeOrder', [OrderController::class, 'placeOrder'])->name('order.placeOrder');

    // My Orders Route
    Route::get('/my-orders', [MyOrderController::class, 'renderMyOrders'])->name('myOrder.render');
    Route::get('/view-order/{trackingNo}', [MyOrderController::class, 'renderViewOrder'])->name('viewOrder.render');

    // END OF CLIENT SIDE


    // START OF ADMIN SIDE

    Route::middleware(['admin.auth'])->group(function () {
        // Dashboard
        Route::get('/admin/dashboard', function () {
            $totalUsers = count(User::all());
            $totalSubCategories = count(SubCategory::all());
            $totalProducts = count(Product::all());
            $pendingOrders = count(Order::all());

            return view('admin.dashboard', [
                'totalUsers' => $totalUsers,
                'totalSubCategories' => $totalSubCategories,
                'totalProducts' => $totalProducts,
                'pendingOrders' => $pendingOrders,
            ]);
        })->name('admin.dashboard.render');


        // Subcategory Route
        Route::get('/admin/subcategory/create', [SubcategoryController::class, 'create'])->name('admin.sub-category.create');
        Route::post('/admin/subcategory/store', [SubcategoryController::class, 'store'])->name('admin.sub-category.store');
        Route::get('/admin/subcategory/{id}/edit', [SubcategoryController::class, 'edit'])->name('admin.sub-category.edit');
        Route::put('/admin/subcategory/{id}/update', [SubcategoryController::class, 'update'])->name('admin.sub-category.update');
        Route::delete('/admin/subcategory/{id}/destroy', [SubcategoryController::class, 'destroy'])->name('admin.sub-category.destroy');
        Route::get('/admin/subcategory/{category}', [SubcategoryController::class, 'index'])->name('admin.sub-category.index');
        Route::get('/admin/get-subcategories/{category}', [SubcategoryController::class, 'getSubcategories']);


        // Product Route
        Route::get('/admin/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
        Route::post('/admin/products/store', [AdminProductController::class, 'store'])->name('admin.products.store');
        Route::get('/admin/products/{id}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('/admin/products/{id}/update', [AdminProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/admin/products/{id}/destroy', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');
        Route::get('/admin/products/{category}', [AdminProductController::class, 'index'])->name('admin.products.index');
    });

    // END OF ADMIN SIDE
});
