<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SubCategory;

class SubcategoryController extends Controller
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
                $webTitle = "SoleAce - Men's All Subcategories";
                $categoryTitle = "Men's Shoes";
                break;
            case "women":
                $webTitle = "SoleAce - Women's All Subcategories";
                $categoryTitle = "Women's Shoes";
                break;
            case "kid":
                $webTitle = "SoleAce - Kid's All Subcategories";
                $categoryTitle = "Kid's Shoes";
                break;
        }

        $subCategories = SubCategory::where('category', $category)->orderBy('created_at')->get();

        return view('admin.subcategories.index', [
            'webTitle' => $webTitle,
            'categoryTitle' => $categoryTitle,
            'subCategories' => $subCategories
        ]);
    }

    public function create()
    {
        return view('admin.subcategories.create');
    }

    public function store(Request $request)
    {
        $name = $request->name;
        $category = $request->category;
        $status = $request->status ? 1 : 0;

        $subcategory = SubCategory::create([
            'name' => $name,
            'category' => $category,
            'status' => $status
        ]);

        if ($subcategory) {
            return redirect()->route('admin.sub-category.create')->with(
                [
                    'message' => "Subcategory '{$subcategory->name}' created successfully.",
                    'type' => 'success'
                ]
            );
        }
    }

    public function edit($id)
    {
        $subCategory = SubCategory::findOrFail($id);
        return view('admin.subcategories.edit', compact('subCategory'));
    }

    public function update(Request $request)
    {
        $status = $request->status ? 1 : 0;
        $subCategory = SubCategory::findOrFail($request->id);
        $subCategory->update([
            'name' => $request->name,
            'status' => $status,
        ]);

        return redirect()->back()->with(
            [
                'message' => "Subcategory '{$subCategory->name}' updated successfully.",
                'type' => 'success'
            ]
        );
    }

    public function destroy($id)
    {
        $subCategory = SubCategory::findOrFail($id);
        $subCategory->delete();
        return redirect()->back()->with([
            'message' => "Subcategory '{$subCategory->name}' deleted successfully.",
            'type' => 'success'
        ]);
    }

    public function getSubcategories($category)
    {
        $subcategories = SubCategory::where('category', $category)->get();
        return response()->json($subcategories);
    }
}
