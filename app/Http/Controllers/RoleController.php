<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
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


    public function destroy($id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();

            return response()->json(['status' => 'success', 'message' => 'Role deleted successfully.'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()], 500);
        }
    }
}
