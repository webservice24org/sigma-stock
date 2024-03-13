<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $warehouses = Warehouse::all();
        return view('layouts.pages.warehouses', compact('warehouses'));
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
        try {
            $validatedData = $request->validate([
                'warehouse_name' => 'required|string|max:25|unique:warehouses',
                'warehouse_address' => 'required|string|max:255'
            ]);         
            
            $warehouse = new Warehouse();
            $warehouse->user_id = auth()->id(); 
            $warehouse->warehouse_name = $validatedData['warehouse_name'];
            $warehouse->warehouse_address = $validatedData['warehouse_address'];

            $warehouse->save();
            
            return response()->json(['status' => 'success', 'message' => 'Warehouse created successfully', 'warehouse'=>$warehouse], 201);
        } catch (ValidationException $e) {
            return response()->json(['status' => 'failed', 'message' => $e->validator->errors()->first()], 422);
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
            $warehouse = Warehouse::findOrFail($id);
            return response()->json(['status' => 'success', 'warehouse' => $warehouse], 200);
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
            $warehouse = Warehouse::findOrFail($id);
            $warehouse->update([
                'user_id' => auth()->id(),
                'warehouse_name' => $request->warehouse_name,
                'warehouse_address' => $request->warehouse_address,
            ]);

            return response()->json(['status' => 'success', 'message' => 'Warehouse updated successfully.', 'warehouse' => $warehouse], 200);
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
            $warehouse = Warehouse::findOrFail($id);
            $warehouse->delete();

            return response()->json(['status' => 'success', 'message' => 'Category deleted successfully.'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()], 500);
        }
    }
    

}
