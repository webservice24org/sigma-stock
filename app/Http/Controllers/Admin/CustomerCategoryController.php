<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerCategory;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
class CustomerCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customerCategories = CustomerCategory::all();
        return view('layouts.pages.customer-categories', compact('customerCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'cat_name' => 'required|string|min:3|max:255|unique:customer_categories',
        ]);
    
        try {
            $customerCategory = new CustomerCategory();
            
            $customerCategory->cat_name = $request->input('cat_name');
            $customerCategory->user_id = Auth::id();
            $customerCategory->save();
    
            return response()->json(['status' => 'success', 'message' => 'Customer category created successfully.', 'category' => $customerCategory], 201);
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
            $category = CustomerCategory::findOrFail($id);
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
            'cat_name' => 'required|string|min:3|max:255|unique:customer_categories',
        ]);

        try {
            $customerCategory = CustomerCategory::findOrFail($id);
            
            // Update the customer category data
            $customerCategory->update([
                'cat_name' => $request->input('cat_name'),
            ]);

            return response()->json(['status' => 'success', 'message' => 'Customer category updated successfully.', 'category' => $customerCategory], 200);
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
            $category = CustomerCategory::findOrFail($id);
            $category->delete();

            return response()->json(['status' => 'success', 'message' => 'Category deleted successfully.'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()], 500);
        }
    }

}
