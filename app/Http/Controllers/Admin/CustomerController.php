<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        $categories = CustomerCategory::get();
        $users = User::get();
        return view('layouts.pages.customer', compact('customers', 'categories', 'users'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'category_id' => 'required|exists:customer_categories,id',
            'shopname' => 'required|string|max:255',
            'trade_license' => 'nullable|string|max:255',
            'business_phone' => 'nullable|string|max:20',
            'tax_rate' => 'nullable|numeric',
        ]);

        try {
            $newCustomer = Customer::create([
                'category_id' => $request->input('category_id'),
                'shopname' => $request->input('shopname'),
                'trade_license' => $request->input('trade_license'),
                'business_phone' => $request->input('business_phone'),
                'tax_rate' => $request->input('tax_rate', 0),
                'user_id' => $request->input('user_id')
            ]);

            $customer = $newCustomer->load('category', 'user');

            return response()->json(['status' => 'success', 'message' => 'Customer created successfully.', 'customer' => $customer], 201);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $customer = Customer::findOrFail($id);
            return response()->json(['status' => 'success', 'customer' => $customer], 200);
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
            'category_id' => 'required|exists:customer_categories,id',
            'shopname' => 'required|string|max:255',
            'trade_license' => 'nullable|string|max:255',
            'business_phone' => 'nullable|string|max:20',
            'tax_rate' => 'nullable|numeric',
        ]);

        try {
            $oldCustomer = Customer::findOrFail($id);
            $oldCustomer->update([
                'category_id' => $request->input('category_id'),
                'shopname' => $request->input('shopname'),
                'trade_license' => $request->input('trade_license'),
                'business_phone' => $request->input('business_phone'),
                'tax_rate' => $request->input('tax_rate', 0),
                'user_id' => $request->input('user_id')
            ]);

            $customer = $oldCustomer->load('category', 'user');

            return response()->json(['status' => 'success', 'message' => 'Customer updated successfully.', 'customer' => $customer], 200);
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
            $customer = Customer::findOrFail($id);
            $customer->delete();

            return response()->json(['status' => 'success', 'message' => 'Customer deleted successfully.'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()], 500);
        }
    }
}
