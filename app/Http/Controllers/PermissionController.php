<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Exception;
use Spatie\Permission\Models\Permission;


class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view("roles-permissions.permissions.index", compact("permissions"));
    }


    public function create()
    {
        return view("roles-permissions.permissions.create");
    }


    public function store(Request $request)
    {
        $request->validate([
            "name"=> ["required","string","unique:permissions,name"],
        ]);
        Permission::create([
            "name"=> $request->name,
        ]);
        return redirect()->route("permissions.index")->with("success","Permission Added!");
    }

    public function show(string $id)
    {
        //
    }


    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('roles-permissions.permissions.edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:permissions,name,' . $id],
        ]);

        $permission = Permission::findOrFail($id);
        $permission->update([
            'name' => $request->name,
        ]);

        return redirect()->route("permissions.index")->with('success', 'Permission updated successfully!');
    }



    
    public function destroy($permissionId)
    {
        try {
            // Perform the delete operation directly via the DB facade
            $deleted = DB::table('permissions')->where('id', $permissionId)->delete();

            if ($deleted) {
                return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully!');
            } else {
                return redirect()->route('permissions.index')->with('error', 'Permission not found or could not be deleted.');
            }
        } catch (\Exception $e) {
            return redirect()->route('permissions.index')->with('error', 'Error: ' . $e->getMessage());
        }
    }
    




}
