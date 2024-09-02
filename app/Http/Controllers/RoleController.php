<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Log;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
class RoleController extends Controller
{
    
    public function index()
    {
        $roles = Role::all();
        return view("roles-permissions.roles.index", compact("roles"));
    }


    public function create()
    {
        return view("roles-permissions.roles.create");
    }


    public function store(Request $request)
    {
        $request->validate([
            "name"=> ["required","string","unique:roles,name"],
        ]);
        Role::create([
            "name"=> $request->name,
        ]);
        return redirect()->route("roles.index")->with("success","Role Added!");
    }

    public function show(string $id)
    {
        //
    }


    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('roles-permissions.roles.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:roles,name,' . $id],
        ]);

        $role = Role::findOrFail($id);
        $role->update([
            'name' => $request->name,
        ]);

        return redirect()->route("roles.index")->with('success', 'Role updated successfully!');
    }



    
    public function destroy($roleId)
    {
        try {
            // Attempt to find the role using the Role model
            $role = Role::findById($roleId);
    
            if (!$role) {
                return response()->json(['success' => false, 'message' => 'Role not found.'], 404);
            }
    
            // Perform the delete operation using the DB facade
            $deleted = DB::table('roles')->where('id', $roleId)->delete();
    
            if ($deleted) {
                return redirect()->route('roles.index')->with('success', 'Permission deleted successfully!');
            } else {
                return redirect()->route('roles.index')->with('error', 'Permission not found or could not be deleted.');
            }
        } catch (\Exception $e) {
            Log::error('Error deleting role: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred.'], 500);
        }
    }
    


    public function givePermission($roleId)
    {
        $role = Role::findOrFail($roleId); 
        $permissions = permission::get();
        $rolePermissions = DB::table('role_has_permissions')
                                    ->where('role_has_permissions.role_id', $role->id)
                                    ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
                                    ->all();
        return view('roles-permissions.roles.give-permissions', compact('role', 'permissions', 'rolePermissions'));
    }

    public function updatePermission(Request $request, $roleId)
    {
        $request->validate([
            'permission' => 'required'
        ]);
        $role = Role::findOrFail($roleId);
        $role->syncPermissions($request->permission);
        return redirect()->route('roles.index')->with('success','Permission added!');
    }
}
