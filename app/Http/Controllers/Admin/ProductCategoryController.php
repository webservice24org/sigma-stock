<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = ProductCategory::all();
        return view('layouts.pages.product-categories', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|min:3|max:255|unique:product_categories',
        ]);

        try {
            $new = ProductCategory::create([
                'name' => $request->input('name'),
                'user_id' => Auth::id(),
            ]);
            $productCategory = $new->load('createdBy');

            return response()->json(['status' => 'success', 'message' => 'Product category created successfully.', 'category' => $productCategory], 201);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $category = ProductCategory::findOrFail($id);
            return response()->json(['status' => 'success', 'category' => $category], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|min:3|max:255|unique:product_categories',
        ]);

        try {
            $oldProductCategory = ProductCategory::findOrFail($id);
            $oldProductCategory->update([
                'name' => $request->input('name'),
            ]);

            $productCategory = $oldProductCategory->fresh('createdBy');

            return response()->json(['status' => 'success', 'message' => 'Product category updated successfully.', 'category' => $productCategory], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()], 500);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $category = ProductCategory::findOrFail($id);
            $category->delete();

            return response()->json(['status' => 'success', 'message' => 'Category deleted successfully.'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()], 500);
        }
    }
}
