<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminManagementController extends Controller
{
    public function index()
    {
        // Get users with admin role (both 'admin' and 'superadmin')
        $admins = User::whereIn('role', ['admin', 'superadmin'])->get();
        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,superadmin',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.admins.index')->with('success', 'Admin user created successfully!');
    }

    public function show(User $admin)
    {
        return view('admin.admins.show', compact('admin'));
    }

    public function edit(User $admin)
    {
        return view('admin.admins.edit', compact('admin'));
    }

    public function update(Request $request, User $admin)
    {
        // Prevent super admin from demoting themselves
        if ($admin->role === 'superadmin' && $request->role !== 'superadmin' && auth()->user()->id === $admin->id) {
            return redirect()->back()->with('error', 'You cannot change your own Super Admin role.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'role' => 'required|in:admin,superadmin',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect()->route('admin.admins.index')->with('success', 'Admin user updated successfully!');
    }

    public function destroy(User $admin)
    {
        // Prevent deletion of self
        if (auth()->user()->id === $admin->id) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        // Prevent deletion of the last super admin
        if ($admin->role === 'superadmin' && User::where('role', 'superadmin')->count() === 1) {
            return redirect()->back()->with('error', 'Cannot delete the last Super Admin account.');
        }

        $admin->delete();

        return redirect()->route('admin.admins.index')->with('success', 'Admin user deleted successfully!');
    }
}
