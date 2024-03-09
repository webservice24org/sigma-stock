<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return view('layouts.pages.suppliers', compact('suppliers'));
    }

    public function allUsers()
    {
        $users = User::all();
        return response()->json(['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'shopname' => 'required|string|max:255',
            'trade_license' => 'required|string|max:255',
            'business_phone' => 'required|string|max:20',
        ]);
    
        try {
            $supplier = new Supplier();
            
            $supplier->user_id = $request->input('user_id');
            $supplier->created_by = auth()->id();
            $supplier->shopname = $request->input('shopname');
            $supplier->trade_license = $request->input('trade_license');
            $supplier->business_phone = $request->input('business_phone');
            
            $supplier->save();
    
            return response()->json(['status' => 'success', 'message' => 'Supplier created successfully.', 'supplier' => $supplier], 201);
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $supplier = Supplier::findOrFail($id);
            
            $supplier->delete();
            
            return response()->json(['status' => 'success', 'message' => 'Supplier deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed', 'message' => 'Failed to delete supplier: ' . $e->getMessage()]);
        }
    }

    
}
