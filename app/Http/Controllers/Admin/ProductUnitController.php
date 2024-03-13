<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductUnit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productUnits = ProductUnit::all();
        return view('layouts.pages.product-units', compact('productUnits'));
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
        $request->validate([
            'unit_name' => 'required|string|min:3|max:255|unique:product_units',
        ]);
    
        try {
            $unit = new ProductUnit();
            
            $unit->unit_name = $request->input('unit_name');
            $unit->user_id = Auth::id();
            $unit->save();
    
            return response()->json(['status' => 'success', 'message' => 'Product Unit created successfully.', 'unit' => $unit], 201);
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
        try {
            $unit = ProductUnit::findOrFail($id);
            return response()->json(['status' => 'success', 'unit' => $unit], 200);
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
            $unit = ProductUnit::findOrFail($id);
            $unit->update([
                'unit_name' => $request->input('unit_name'),
                'user_id' => Auth::id()
            ]);

            return response()->json(['status' => 'success', 'message' => 'Product Unit updated successfully.', 'unit' => $unit], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $unit = ProductUnit::findOrFail($id);
            $unit->delete();

            return response()->json(['status' => 'success', 'message' => 'Product Unit deleted successfully.'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()], 500);
        }
    }
}
