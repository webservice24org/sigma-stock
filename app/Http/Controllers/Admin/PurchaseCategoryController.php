<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PurchaseCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchaseCates = PurchaseCategory::all();
        return view('layouts.pages.purchase-categories', compact('purchaseCates'));
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
            'purchase_cat_name' => 'required|string|min:3|max:30|unique:purchase_categories',
        ]);

        try {
            $purchaseCat = new PurchaseCategory();

            $purchaseCat->purchase_cat_name = $request->input('purchase_cat_name');
            $purchaseCat->user_id = Auth::id();
            $purchaseCat->save();

            return response()->json(['status' => 'success', 'message' => 'Purchase Category Ccreated successfully.', 'purchaseCat' => $purchaseCat], 201);
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
            $purchaseCat = PurchaseCategory::findOrFail($id);
            return response()->json(['status' => 'success', 'purchaseCat' => $purchaseCat], 200);
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
            $purchaseCat = PurchaseCategory::findOrFail($id);
            $purchaseCat->update([
                'purchase_cat_name' => $request->input('purchase_cat_name'),
                'user_id' => Auth::id()
            ]);

            return response()->json(['status' => 'success', 'message' => 'Purchase Category updated successfully.', 'purchaseCat' => $purchaseCat], 200);
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
            $purchaseCat = PurchaseCategory::findOrFail($id);
            $purchaseCat->delete();

            return response()->json(['status' => 'success', 'message' => 'Purchase Category deleted successfully.'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()], 500);
        }
    }
}
