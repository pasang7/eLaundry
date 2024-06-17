<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('admin.role.index', compact('roles'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'role_name' => 'required|unique:roles|max:255',

        ]);
        $role = new Role();
        $role->role_name = $request['role_name'];
        $role->save();
        if ($role->save()) {
            return redirect()->back()->with('success', 'Successfully added ' . $role->role_name . ' role');
        } else {
            return redirect()->back()->with('error', 'Unable to add ' . $role->role_name . '  role');
        }
    }
}
