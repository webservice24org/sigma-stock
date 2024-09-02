<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();
        return view("roles-permissions.users.index", compact("users"));
    }

    public function create()
{
    $roles = Role::all();
    \Log::info('Roles:', $roles->toArray()); // Log roles to verify
    return view("roles-permissions.users.create", compact('roles'));
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validate the request data
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:6|confirmed',
        'profile_photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'role' => 'required|exists:roles,id', // Validate the selected role
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    try {
        // Handle the file upload
        $profilePhotoPath = null;
        if ($request->hasFile('profile_photo_path')) {
            $image = $request->file('profile_photo_path');
            $imageName = 'sigma' . '_' . md5(uniqid()) . '_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/admin/img/users'), $imageName);
            $profilePhotoPath = 'assets/admin/img/users/' . $imageName;
        }

        // Create a new user
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->profile_photo_path = $profilePhotoPath;
        $user->save();

        // Assign the selected role
        $role = Role::findById($request->input('role'));
        if ($role) {
            $user->assignRole($role);
        } else {
            return redirect()->route('users.index')->with('error', 'Role not found.');
        }

        // Redirect with success message
        return redirect()->route('users.index')->with('success', 'User added successfully!');
    } catch (\Exception $e) {
        \Log::error('Error in storing user: ' . $e->getMessage()); // Log error details
        return redirect()->route('users.index')->with('error', 'Error: ' . $e->getMessage());
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
    // Fetch the specific user by ID
    $user = User::find($id);

    // Check if the user exists
    if (!$user) {
        return redirect()->route('users.index')->with('error', 'User not found.');
    }

    // Fetch all roles
    $roles = Role::all();

    // Log roles for debugging
    \Log::info('Roles:', $roles->toArray());

    // Return the view with the user and roles data
    return view('roles-permissions.users.edit', compact('user', 'roles'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    // Validate the request data
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'password' => 'nullable|string|min:6|confirmed',
        'profile_photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'role' => 'required|exists:roles,id',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    try {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Handle the file upload
        $profilePhotoPath = $request->input('old_profile_photo_path'); // Use old photo path initially
        if ($request->hasFile('profile_photo_path')) {
            // Delete the old profile photo if it exists
            if ($profilePhotoPath && file_exists(public_path($profilePhotoPath))) {
                unlink(public_path($profilePhotoPath));
            }

            // Upload the new profile photo
            $image = $request->file('profile_photo_path');
            $imageName = 'sigma' . '_' . md5(uniqid()) . '_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/admin/img/users'), $imageName);
            $profilePhotoPath = 'assets/admin/img/users/' . $imageName;
        }

        // Update the user’s data
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->profile_photo_path = $profilePhotoPath;
        $user->save();

        // Update the user’s role
        $role = Role::findById($request->input('role'));
        if ($role) {
            $user->syncRoles($role); // Sync the role(s) assigned to the user
        } else {
            return redirect()->route('users.index')->with('error', 'Role not found.');
        }

        // Redirect with success message
        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    } catch (\Exception $e) {
        // Redirect with error message
        return redirect()->route('users.index')->with('error', 'Error: ' . $e->getMessage());
    }
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Find the user by ID
            $user = User::findOrFail($id);
    
            // Delete the profile photo if it exists
            if ($user->profile_photo_path && file_exists(public_path($user->profile_photo_path))) {
                unlink(public_path($user->profile_photo_path));
            }
    
            // Delete the user record
            $user->delete();
            
    
            // Return JSON response
            return response()->json([
                'status' => 'success',
                'message' => 'User deleted successfully!'
            ]);
        } catch (\Exception $e) {
            // Return JSON response with error message
            return response()->json([
                'status' => 'failed',
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function logout(Request $request)
    {
        try {
            // Log out the authenticated user
            Auth::logout();
            
            // Invalidate the user session
            $request->session()->invalidate();
    
            // Regenerate the session token to prevent session fixation attacks
            $request->session()->regenerateToken();
    
            // Redirect to the login page or a different route
            return redirect()->route('login')->with('success', 'Logged out successfully!');
        } catch (\Exception $e) {
            // Return redirect with error message in case of exception
            return redirect()->route('login')->with('error', 'Error: ' . $e->getMessage());
        }
    }
    

}
