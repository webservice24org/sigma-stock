<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\HrmDepartment;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
    public function show($id)
    {
        try {
            $employee = Employee::select(
                'employees.id',
                'employees.user_id',
                'employees.hrm_department_id',
                'employees.salary_amount',
                'employees.joining_date',
                'employees.status',
                'employees.note',
                'employees.regine_date',
                'users.name as user_name',
                'users.email',
                'users.profile_photo_path',
                'user_details.phone',
                'user_details.address',
                'user_details.dob',
                'user_details.nid',
                'user_details.bank_name',
                'user_details.account_holder',
                'user_details.account_number',
                'hrm_departments.department_name'
            )
                ->join('users', 'employees.user_id', '=', 'users.id')
                ->leftJoin('user_details', 'users.id', '=', 'user_details.user_id')
                ->leftJoin('hrm_departments', 'employees.hrm_department_id', '=', 'hrm_departments.id')
                ->findOrFail($id);

            return response()->json(['status' => 'success', 'employee' => $employee], 200);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['status' => 'failed', 'message' => 'Employee data not found.'], 404);
        } catch (Exception $ex) {
            return response()->json(['status' => 'failed', 'message' => $ex->getMessage()], 500);
        }
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $employee = Employee::with('department')->find($id);
        return response()->json(['employee' => $employee], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            // $request->validate([
            //     'user_id' => 'required|exists:users,id|',
            //     'hrm_department_id' => 'required|exists:hrm_departments,id',
            //     'salary_amount' => 'required|numeric|min:0',
            //     'joining_date' => 'nullable|date',
            //     'regine_date' => 'nullable|date',
            //     'note' => 'nullable|string',
            // ]);
            
            $employee = Employee::findOrFail($id);
            $employee->user_id = $request->user_id;
            $employee->hrm_department_id = $request->hrm_department_id;
            $employee->salary_amount = $request->salary_amount;
            //$employee->joining_date = $request->joining_date;
            $employee->regine_date = $request->regine_date;
            $employee->note = $request->note;
            
            $employee->save();
            
            return response()->json(['status' => 'success', 'message' => 'Employee updated successfully', 'employee' => $employee], 200);
        } catch (ValidationException $e) {
            return response()->json(['status' => 'failed', 'message' => $e->validator->errors()->first()], 422);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['status' => 'failed', 'message' => 'Employee not found.'], 404);
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
            $employee = Employee::findOrFail($id);

            $employee->delete();

            return response()->json(['status' => 'success', 'message' => 'Employee deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed', 'message' => 'Failed to delete Employee: ' . $e->getMessage()]);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['status' => 'failed', 'message' => 'Employee not found'], 404);
        }
        $employee->status = $request->status;
        $employee->save();

        return response()->json(['status' => 'success', 'message' => 'Status updated successfully'], 200);
    }

}
