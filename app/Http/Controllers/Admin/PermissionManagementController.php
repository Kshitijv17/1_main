<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PermissionManagementController extends Controller
{
    /**
     * Display a listing of permissions and users
     */
    public function index()
    {
        // Get all admin users
        $admins = User::where('role', 'admin')->with('permissions')->get();
        
        // Get all permissions grouped by module
        $permissions = Permission::all()->groupBy('module');
        
        return view('admin.permissions.index', compact('admins', 'permissions'));
    }

    /**
     * Show the form for creating a new permission
     */
    public function create()
    {
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created permission
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:permissions,name|max:255',
            'display_name' => 'required|string|max:255',
            'module' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Permission::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'module' => $request->module,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission created successfully.');
    }

    /**
     * Display the specified permission
     */
    public function show(Permission $permission)
    {
        // Get users who have this permission
        $usersWithPermission = $permission->users()->get();
        
        // Get all permissions grouped by module for context
        $permissions = Permission::all()->groupBy('module');
        
        return view('admin.permissions.show', compact('permission', 'usersWithPermission', 'permissions'));
    }

    /**
     * Show the form for editing the specified permission
     */
    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified permission
     */
    public function update(Request $request, Permission $permission)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
            'display_name' => 'required|string|max:255',
            'module' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $permission->update([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'module' => $request->module,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission updated successfully.');
    }

    /**
     * Remove the specified permission
     */
    public function destroy(Permission $permission)
    {
        // Detach permission from all users first
        $permission->users()->detach();
        
        // Delete the permission
        $permission->delete();

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission deleted successfully.');
    }

    /**
     * Show permissions for a specific user
     */
    public function showUser(User $user)
    {
        // Get all permissions grouped by module
        $permissions = Permission::all()->groupBy('module');
        
        // Get user's current permissions
        $userPermissions = $user->permissions->pluck('name')->toArray();
        
        return view('admin.permissions.user', compact('user', 'permissions', 'userPermissions'));
    }

    /**
     * Update permissions for a specific user
     */
    public function updateUser(Request $request, User $user)
    {
        $permissions = $request->input('permissions', []);
        
        // Sync permissions (this will add new ones and remove old ones)
        $permissionIds = Permission::whereIn('name', $permissions)->pluck('id')->toArray();
        $user->permissions()->sync($permissionIds);
        
        return redirect()->route('admin.permissions.user.show', $user)
            ->with('success', 'User permissions updated successfully.');
    }

    /**
     * Bulk assign permissions to multiple users
     */
    public function bulkAssign(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'permission_id' => 'required|exists:permissions,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid data provided.'
            ], 400);
        }

        $permission = Permission::find($request->permission_id);
        $users = User::whereIn('id', $request->user_ids)->get();
        
        foreach ($users as $user) {
            if (!$user->permissions->contains($permission->id)) {
                $user->permissions()->attach($permission->id);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Permission assigned to ' . count($users) . ' user(s) successfully.'
        ]);
    }

    /**
     * Bulk update permissions for a user
     */
    public function bulkUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid data provided.'
            ], 400);
        }

        $user = User::find($request->user_id);
        $permissionIds = Permission::whereIn('name', $request->permissions)->pluck('id')->toArray();
        
        // Sync permissions
        $user->permissions()->sync($permissionIds);

        return response()->json([
            'success' => true,
            'message' => 'Permissions updated successfully.'
        ]);
    }

    /**
     * Remove a permission from a user
     */
    public function removeFromUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'permission_id' => 'required|exists:permissions,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid data provided.'
            ], 400);
        }

        $user = User::find($request->user_id);
        $permission = Permission::find($request->permission_id);
        
        // Detach the permission from the user
        $user->permissions()->detach($permission->id);

        return response()->json([
            'success' => true,
            'message' => 'Permission removed from user successfully.'
        ]);
    }
}
