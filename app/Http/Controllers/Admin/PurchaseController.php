<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductUnit;
use App\Models\Purchase;
use App\Models\PurchaseCategory;
use App\Models\Supplier;
use App\Models\Warehouse;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Purchase::all();
        return view("layouts.pages.purchases", compact("purchases"));
    }

    public function allSuppliers()
    {
        $allSuppliers = Supplier::all();
        return response()->json(['allSuppliers' => $allSuppliers]);

    }
    public function allwarehouses()
    {
        $allwarehouses = Warehouse::all();
        return response()->json(['allwarehouses' => $allwarehouses]);

    }
    public function allPurchseCats()
    {
        $allPurchseCats = PurchaseCategory::all();
        return response()->json(['allPurchseCats' => $allPurchseCats]);
    }
    public function allUnits()
    {
        $allUnits = ProductUnit::all();
        return response()->json(['allUnits' => $allUnits]);
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
        $validatedData = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'purchase_category_id' => 'required|exists:purchase_categories,id',
            'unit_id' => 'required|exists:product_units,id',
            'date' => 'required|date',
            'tax_rate' => 'nullable|numeric|min:0',
            'payment_statut' => 'required|integer|in:0,1',
            'notes' => 'nullable|string',
            'discount' => 'nullable|numeric|min:0',
            'shipping_cost' => 'nullable|numeric|min:0',
            'purchase_qty' => 'nullable|numeric|min:0',
            'grand_total' => 'nullable|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'due_amount' => 'nullable|numeric|min:0',
        ]);

        try {
            $purchase = new Purchase();

            $purchase->fill($validatedData);
            $purchase->user_id = Auth::id();
            $purchase->save();

            return response()->json(['status' => 'success', 'message' => 'Purchase created successfully', 'purchase' => $purchase], 201);
        } catch (Exception $ex) {
            return response()->json(['status' => 'failed', 'message' => $ex->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $purchase = Purchase::select(
                'purchases.*',
                'users.name as user_name',
                'suppliers.shopname as supplier_shop',
                'warehouses.warehouse_name',
                'purchase_categories.purchase_cat_name',
                'product_units.unit_name'
            )
                ->join('users', 'purchases.user_id', '=', 'users.id')
                ->join('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
                ->join('warehouses', 'purchases.warehouse_id', '=', 'warehouses.id')
                ->join('purchase_categories', 'purchases.purchase_category_id', '=', 'purchase_categories.id')
                ->join('product_units', 'purchases.unit_id', '=', 'product_units.id')
                ->findOrFail($id);
            return response()->json(['status' => 'success', 'purchase' => $purchase], 200);
        } catch (Exception $ex) {
            return response()->json(['status' => 'failed', 'message' => 'Purchase data not found.'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $purchase = Purchase::with(['allSuppliers', 'allwarehouses', 'allPurchseCats', 'allUnits'])->find($id);
        return response()->json(['purchase' => $purchase], 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'purchase_category_id' => 'required|exists:purchase_categories,id',
            'unit_id' => 'required|exists:product_units,id',
            'date' => 'required|date',
            'tax_rate' => 'nullable|numeric|min:0',
            'payment_statut' => 'required|integer|in:0,1',
            'notes' => 'nullable|string',
            'discount' => 'nullable|numeric|min:0',
            'shipping_cost' => 'nullable|numeric|min:0',
            'purchase_qty' => 'nullable|numeric|min:0',
            'grand_total' => 'nullable|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'due_amount' => 'nullable|numeric|min:0',
        ]);

        try {
            $purchase = Purchase::findOrFail($id);
            $purchase->fill($validatedData);
            $purchase->user_id = Auth::id();
            $purchase->save();

            return response()->json(['status' => 'success', 'message' => 'Purchase updated successfully', 'purchase' => $purchase], 200);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['status' => 'failed', 'message' => 'Purchase not found.'], 404);
        } catch (Exception $ex) {
            return response()->json(['status' => 'failed', 'message' => $ex->getMessage()], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $purchase = Purchase::findOrFail($id);

            $purchase->delete();

            return response()->json(['status' => 'success', 'message' => 'Purchase deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed', 'message' => 'Failed to delete Purchase: ' . $e->getMessage()]);
        }
    }
}
