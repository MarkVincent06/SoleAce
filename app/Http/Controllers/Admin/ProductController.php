<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index($category = null)
    {
        $validCategories = ['men', 'women', 'kid'];
        if (!in_array($category, $validCategories)) {
            return redirect()->back()->with([
                'message' => 'The URL does not exist.',
                'type' => 'error'
            ]);
        }

        $webTitle = null;
        $categoryTitle = null;
        switch ($category) {
            case "men":
                $webTitle = "SoleAce - Men's All Products";
                $categoryTitle = "Men's Shoes";
                break;
            case "women":
                $webTitle = "SoleAce - Women's All Products";
                $categoryTitle = "Women's Shoes";
                break;
            case "kid":
                $webTitle = "SoleAce - Kid's All Products";
                $categoryTitle = "Kid's Shoes";
                break;
        }

        $products = Product::where('category', $category)->orderBy('created_at')->get();

        return view('admin.products.index', [
            'webTitle' => $webTitle,
            'categoryTitle' => $categoryTitle,
            'products' => $products
        ]);
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'subcategory_id' => 'required|integer',
            'category' => 'required|string|max:200',
            'name' => 'required|string|max:200',
            'slug' => 'required|string|max:200',
            'small-description' => 'nullable|string',
            'description' => 'nullable|string',
            'original-price' => 'required|numeric|between:0,99999999.99',
            'selling-price' => 'required|numeric|between:0,99999999.99',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'quantity' => 'required|integer|min:0',
            'meta-title' => 'nullable|string|max:200',
            'meta-description' => 'nullable|string',
            'meta-keywords' => 'nullable|string',
        ]);

        $filename = null;
        // Handle the file upload if there is an image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('uploads', $filename, 'public'); // Store in public/uploads
        } else {
            $filename = "default-shoe-image.png";
        }

        $product = Product::create([
            'sub_category_id' => $validatedData['subcategory_id'],
            'category' => $validatedData['category'],
            'name' => $validatedData['name'],
            'slug' => $validatedData['slug'],
            'small_description' => $validatedData['small-description'],
            'description' => $validatedData['description'],
            'original_price' => $validatedData['original-price'],
            'selling_price' => $validatedData['selling-price'],
            'image' => $filename,
            'quantity' => $validatedData['quantity'],
            'status' => $request->status ? 1 : 0,
            'featured' => $request->featured ? 1 : 0,
            'trending' => $request->trending ? 1 : 0,
            'meta_title' => $validatedData['meta-title'],
            'meta_description' => $validatedData['meta-description'],
            'meta_keywords' => $validatedData['meta-keywords'],
        ]);

        if ($product) {
            return redirect()->route('admin.products.create')->with(
                [
                    'message' => "Product '{$product->name}' created successfully.",
                    'type' => 'success'
                ]
            );
        } else {
            return redirect()->back()->with(
                [
                    'message' => "There was an error creating the product.",
                    'type' => 'error'
                ]
            );
        }
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'subcategory_id' => 'required|integer',
            'category' => 'required|string|max:200',
            'name' => 'required|string|max:200',
            'slug' => 'required|string|max:200',
            'small-description' => 'nullable|string',
            'description' => 'nullable|string',
            'original-price' => 'required|numeric|between:0,99999999.99',
            'selling-price' => 'required|numeric|between:0,99999999.99',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'quantity' => 'required|integer|min:0',
            'meta-title' => 'nullable|string|max:200',
            'meta-description' => 'nullable|string',
            'meta-keywords' => 'nullable|string',
        ]);

        // This is the old image
        $filename = $request['old-image'];

        // Handle the file upload if there is an image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('uploads', $filename, 'public'); // Store in public/uploads
        }

        $product = Product::findOrFail($id);

        $product->update([
            'sub_category_id' => $validatedData['subcategory_id'],
            'category' => $validatedData['category'],
            'name' => $validatedData['name'],
            'slug' => $validatedData['slug'],
            'small_description' => $validatedData['small-description'],
            'description' => $validatedData['description'],
            'original_price' => $validatedData['original-price'],
            'selling_price' => $validatedData['selling-price'],
            'image' => $filename,
            'quantity' => $validatedData['quantity'],
            'status' => $request->status ? 1 : 0,
            'featured' => $request->featured ? 1 : 0,
            'trending' => $request->trending ? 1 : 0,
            'meta_title' => $validatedData['meta-title'],
            'meta_description' => $validatedData['meta-description'],
            'meta_keywords' => $validatedData['meta-keywords'],
        ]);

        if ($product) {
            return redirect()->back()->with(
                [
                    'message' => "Product '{$product->name}' updated successfully.",
                    'type' => 'success'
                ]
            );
        } else {
            return redirect()->back()->with(
                [
                    'message' => "There was an error updating the product.",
                    'type' => 'error'
                ]
            );
        }
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Check if the product has an image and delete it from the storage except for default image
        if ($product->image && $product->image !== 'default-shoe-image.png') {
            $imagePath = storage_path('app/public/uploads/' . $product->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $product->delete();

        return redirect()->back()->with([
            'message' => "Product '{$product->name}' deleted successfully.",
            'type' => 'success'
        ]);
    }
}
