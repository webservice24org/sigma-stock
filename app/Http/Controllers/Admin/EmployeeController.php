<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\HrmDepartment;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use View;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::all();
        return View('layouts.pages.employee', compact('employees'));
    }

    public function allDepartments()
    {
        $departments = HrmDepartment::all();
        return response()->json(['departments' => $departments]);
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
                'user_id' => 'required|exists:users,id|unique:employees,user_id',
                'hrm_department_id' => 'required|exists:hrm_departments,id',
                'salary_amount' => 'required|numeric|min:0',
                'joining_date' => 'required|date',
                'note' => 'nullable|string',
            ]);
    
            $employee = new Employee();
            $employee->user_id = $validatedData['user_id'];
            $employee->hrm_department_id = $validatedData['hrm_department_id'];
            $employee->salary_amount = $validatedData['salary_amount'];
            $employee->joining_date = $validatedData['joining_date'];
            $employee->note = $validatedData['note'];
    
            $employee->save();
    
            return response()->json(['status' => 'success', 'message' => 'Employee created successfully', 'employee' => $employee], 201);
        } catch (ValidationException $e) {
            return response()->json(['status' => 'failed', 'message' => $e->validator->errors()->first()], 422);
        } catch (QueryException $ex) {
            if ($ex->errorInfo[1] === 1062) {
                return response()->json(['status' => 'failed', 'message' => 'User is already an employee'], 409);
            }
            return response()->json(['status' => 'failed', 'message' => $ex->getMessage()], 500);
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
            $employee = Employee::findOrFail($id);

            $employee->delete();

            return response()->json(['status' => 'success', 'message' => 'Employee deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed', 'message' => 'Failed to delete Employee: ' . $e->getMessage()]);
        }
    }
}
