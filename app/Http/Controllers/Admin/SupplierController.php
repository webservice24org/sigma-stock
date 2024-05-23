<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\User;
use App\Models\UserDetails;
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
            $supplier->note = $request->input('note');

            $supplier->save();

            return response()->json(['status' => 'success', 'message' => 'Supplier created successfully.', 'supplier' => $supplier], 201);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()], 500);
        }
    }


    public function show($id)
    {
        $supplier = Supplier::select('suppliers.*', 'users.name as supplier_name', 'users.email as user_email', 'created_by.name as created_by_name', 'user_details.*')
            ->join('users', 'suppliers.user_id', '=', 'users.id')
            ->leftJoin('user_details', 'users.id', '=', 'user_details.user_id')
            ->leftJoin('users as created_by', 'suppliers.created_by', '=', 'created_by.id')
            ->where('suppliers.id', $id)
            ->first();

        if (!$supplier) {
            return response()->json(['status' => 'failed', 'message' => 'Supplier Not found']);
        }

        return response()->json(['supplier' => $supplier], 200);
    }




    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $supplier = Supplier::with('user')->find($id);
        return response()->json(['supplier' => $supplier], 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'shopname' => 'required|string',
            'trade_license' => 'required|string',
            'business_phone' => 'required|string',
            'note' => 'nullable|string',
        ]);
        $supplier = Supplier::findOrFail($id);
        $supplier->user_id = $request->user_id;
        $supplier->created_by = auth()->id();
        $supplier->shopname = $request->shopname;
        $supplier->trade_license = $request->trade_license;
        $supplier->business_phone = $request->business_phone;
        $supplier->note = $request->note;
        $supplier->save();
        return response()->json(['message' => 'Supplier updated successfully', 'supplier' => $supplier], 200);
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

    public function updateStatus(Request $request, $id)
    {
        $supplier = Supplier::find($id);
        if (!$supplier) {
            return response()->json(['status' => 'failed', 'message' => 'Supplier not found'], 404);
        }

        // Update status based on request data
        $supplier->status = $request->status;
        $supplier->save();

        return response()->json(['status' => 'success', 'message' => 'Status updated successfully'], 200);
    }


    /*
    public function userDetails($id)
    {
        $user = UserDetails::findOrFail($id);
        dd($user);
    }
    */

}
