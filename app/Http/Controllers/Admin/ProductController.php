<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductUnit;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::get();

        $categories = ProductCategory::get();
        $units = ProductUnit::get();

        return view('layouts.pages.product', compact('products', 'categories', 'units'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'type_barcode' => 'required|string',
            'name' => 'required|string',
            'making_cost' => 'required|numeric|min:0',
            'general_price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:product_categories,id',
            'unit_id' => 'required|exists:product_units,id',
            'discount' => 'nullable|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'note' => 'nullable|string',
            'stock_alert' => 'nullable|numeric|min:0',
            'product_short_desc' => 'nullable|string',
            'product_long_desc' => 'nullable|string'
        ]);

        try {
            $product = new Product();
            $product->user_id = Auth::id();
            $product->code = $request->code;
            $product->type_barcode = $request->type_barcode;
            $product->name = $request->name;
            $product->making_cost = $request->making_cost;
            $product->general_price = $request->general_price;
            $product->category_id = $request->category_id;
            $product->unit_id = $request->unit_id;
            $product->discount = $request->discount ?? 0;
            $product->tax_rate = $request->tax_rate ?? 0;
            
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = 'sigma'.'_'.md5(uniqid()) . '_' . time(). '.'. $image->getClientOriginalExtension();
                $image->move(public_path('assets/admin/img/products'), $imageName);
                $product->image = 'assets/admin/img/products/' . $imageName;
            }         
            
            $product->note = $request->note;
            $product->stock_alert = $request->stock_alert ?? 0;
            $product->product_short_desc = $request->product_short_desc;
            $product->product_long_desc = $request->product_long_desc;
            
            $product->save();

            return response()->json(['status' => 'success', 'message' => 'Product created successfully', 'product' => $product], 201);
        } catch (Exception $ex) {
            return response()->json(['status' => 'failed', 'message' => $ex->getMessage()], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $product = Product::findOrFail($id);
            return response()->json(['status' => 'success', 'product' => $product], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $request->validate([
        'code' => 'required|string',
            'type_barcode' => 'required|string',
            'name' => 'required|string',
            'making_cost' => 'required|numeric|min:0',
            'general_price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:product_categories,id',
            'unit_id' => 'required|exists:product_units,id',
            'discount' => 'nullable|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'note' => 'nullable|string',
            'stock_alert' => 'nullable|numeric|min:0',
            'product_short_desc' => 'nullable|string',
            'product_long_desc' => 'nullable|string'
    ]);

    try {
        
        $product = Product::findOrFail($id);
        

        $product->user_id = Auth::id();
            $product->code = $request->code;
            $product->type_barcode = $request->type_barcode;
            $product->name = $request->name;
            $product->making_cost = $request->making_cost;
            $product->general_price = $request->general_price;
            $product->category_id = $request->category_id;
            $product->unit_id = $request->unit_id;
            $product->discount = $request->discount ?? 0;
            $product->tax_rate = $request->tax_rate ?? 0;
            $product->stock_alert = $request->stock_alert ?? 0;
            $product->product_desc = $request->product_desc;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = 'sigma'.'_'.md5(uniqid()) . '_' . time(). '.'. $image->getClientOriginalExtension();
                $image->move(public_path('assets/admin/img/products'), $imageName);
                $product->image = 'assets/admin/img/products/' . $imageName;
                if ($product->image && file_exists(public_path($product->image))) {
                    unlink(public_path($product->image));
                }
            } 

        $product->save();

        return response()->json(['status' => 'success', 'message' => 'Product updated successfully', 'product' => $product]);
    } catch (Exception $ex) {
        return response()->json(['status' => 'failed', 'message' => 'Error updating product: ' . $ex->getMessage()]);
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);

            if ($product->image) {
                $imagePath = public_path($product->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            $product->delete();

            return response()->json(['status' => 'success', 'message' => 'Product deleted successfully.'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()], 500);
        }
    }
}
