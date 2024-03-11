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
        try {

            $validator = Validator::make($request->all(), Product::rules());
            if ($validator->fails()) {
                return response()->json(['status' => 'failed', 'message' => $validator->errors()], 422);
            }

            $requestData = $request->except('image');
            $requestData['user_id'] = Auth::id();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/products'), $imageName);
                $requestData['image'] = 'uploads/products/' . $imageName;
            }

            $product = Product::create($requestData);

            return response()->json(['status' => 'success', 'message' => 'Product created successfully.', 'product' => $product], 201);
        } catch (Exception $e) {

            return response()->json(['status' => 'failed', 'message' => $e->getMessage()], 500);
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
        try {
            $oldProduct = Product::findOrFail($id);
            $oldProduct->update([
                'code' => $request->input('code'),
                'category_id' => $request->input('category_id'),
                'unit_id' => $request->input('unit_id'),
                'type_barcode' => $request->input('type_barcode'),
                'name' => $request->input('name'),
                'making_cost' => $request->input('making_cost'),
                'general_price' => $request->input('general_price'),
                'discount' => $request->input('discount'),
                'tax_rate' => $request->input('tax_rate', 0),
                'note' => $request->input('note'),
                'stock_alert' => $request->input('stock_alert'),
            ]);

            $product = $oldProduct->load('category', 'unit', 'createdBy');

            return response()->json(['status' => 'success', 'message' => 'Product updated successfully.', 'product' => $product], 200);
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
