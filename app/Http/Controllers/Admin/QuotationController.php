<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Quotation;
use App\Models\Warehouse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quotations = Quotation::all();
        return view('admin-components.quotation.index', compact('quotations'));
    }
    

    public function create()
    {
        $customers = Customer::all();
        $warehouses = Warehouse::all();
        $products = Product::all();
        return view('admin-components.quotation.create', compact('customers', 'warehouses', 'products'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'customer_id' => 'required|exists:customers,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'tax_percentage' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'shipping_amount' => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'product_id' => 'required|exists:products,id',
            'note' => 'nullable|string',
        ]);

        try {
            $quotation = new Quotation();
            $quotation->user_id = Auth::id();
            $quotation->date = $request->date;
            $quotation->customer_id = $request->customer_id;
            $quotation->warehouse_id = $request->warehouse_id;
            $quotation->tax_percentage = $request->tax_percentage;
            $quotation->discount = $request->discount ?? 0;
            $quotation->shipping_amount = $request->shipping_amount ?? 0;
            $quotation->total_amount = $request->total_amount;
            $quotation->product_id = $request->product_id;
            $quotation->note = $request->note;
            $quotation->save();

            return redirect()->route('quotations.index')->with('success', 'Quotation created successfully');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Error creating quotation: ' . $ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $quotation = Quotation::findOrFail($id);
            return view('admin-components.quotation.view', compact('quotation'));
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Error: ' . $ex->getMessage());
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $quotation = Quotation::findOrFail($id);
        
        $customers = Customer::all();
        $warehouses = Warehouse::all();
        $products = Product::all();
        return view('admin-components.quotation.edit', compact('quotation', 'customers', 'warehouses', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quotation $quotation)
    {
        $request->validate([
            'date' => 'required|date',
            'customer_id' => 'required|exists:customers,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'tax_percentage' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'shipping_amount' => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'product_id' => 'required|exists:products,id',
            'note' => 'nullable|string',
        ]);

        try {
            $quotation->update([
                'date' => $request->date,
                'customer_id' => $request->customer_id,
                'warehouse_id' => $request->warehouse_id,
                'tax_percentage' => $request->tax_percentage,
                'discount' => $request->discount ?? 0,
                'shipping_amount' => $request->shipping_amount ?? 0,
                'total_amount' => $request->total_amount,
                'product_id' => $request->product_id,
                'note' => $request->note,
            ]);

            return redirect()->route('quotations.index')->with('success', 'Quotation updated successfully');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Error updating quotation: ' . $ex->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
