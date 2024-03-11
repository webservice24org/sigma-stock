<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HrmDepartment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HrmDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = HrmDepartment::all();
        return view('layouts.pages.hrm-departments', compact('departments'));
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
    // Controller method to store department name and auth user_id
    public function store(Request $request)
    {
        try {
            $request->validate([
                'department_name' => 'required|string|min:3|max:20|unique:hrm_departments',
            ]);

            $department = new HrmDepartment();
            $department->department_name = $request->department_name;
            $department->user_id = Auth::id();
            $department->save();
            return response()->json(['status' => 'success', 'message' => 'Department created successfully.', 'department' => $department], 200);
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
            $department = HrmDepartment::findOrFail($id);
            return response()->json(['status' => 'success', 'department' => $department], 200);
        } catch (Exception $ex) {
            return response()->json(['status' => 'failed', 'message' => $ex->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'department_name' => 'required|string|min:3|max:20|unique:hrm_departments',
            ]);

            $department = HrmDepartment::findOrFail($id);
            $department->department_name = $request->department_name;
            $department->user_id = Auth::id();
            $department->save();
            return response()->json(['status' => 'success', 'message' => 'Department Updated successfully.', 'department' => $department], 200);
        } catch (Exception $ex) {
            return response()->json(['status' => 'failed', 'message' => $ex->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $department = HrmDepartment::findOrFail($id);

            $department->delete();

            return response()->json(['status' => 'success', 'message' => 'Department deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed', 'message' => 'Failed to delete department: ' . $e->getMessage()]);
        }
    }
}
