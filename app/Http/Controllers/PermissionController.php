<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
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


    public function destroy($id)
    {
        try {
            $permission = Permission::findOrFail($id);
            $permission->delete();

            return response()->json(['status' => 'success', 'message' => 'Permission deleted successfully.'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()], 500);
        }
    }

}
