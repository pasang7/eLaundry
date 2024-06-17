<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function index()
    {

        $users = User::where('id', '!=', 1)->get();
        $roles = Role::all();
        // dd($roles);
        return view('admin.user.index', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6'


        ]);
        $newUser = new User();
        $newUser->name = $request['name'];
        $newUser->email = $request['email'];
        $newUser->password = Hash::make($request['password']);
        $newUser->save();
        //Assigning Default User role while creating


        $role = new RoleUser();
        $role->role_id = $request->role;
        $role->user_id = $newUser->id;
        $role->save();
        if ($newUser->save()) {
            return redirect()->route('admin.users')->with('success', 'User created successfully.');
        } else {
            return redirect()->route('admin.users')->with('error', 'Unable to create user .');
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

        if ($request['password']) {
            $user = User::find($request->id);
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->password = Hash::make($request['password']);
            User::where('id', $request->id)->update(array('name' =>  $user->name, 'email' =>  $user->email, 'password' => $user->password));
            return redirect()->route('admin.users')->with('success', "User updated successfully.");
        }
        $user = User::find($request->id);
        $user->name = $request['name'];
        $user->email = $request['email'];
        User::where('id', $request->id)->update(array('name' =>  $user->name, 'email' =>  $user->email));

        $role = $request->role;
        $getRole = RoleUser::where('user_id', $request->id)->first();
        $getRole->update(['role_id'=>$role]);
        return redirect()->route('admin.users')->with('success', "User updated successfully.");
    }

    public function delete(Request $request, $id)
    {

        User::find($request->id)->delete();
        return redirect()->route('admin.users')->with('warning', "User deleted successfully.");
    }


    public function rolePermissionIndex()
    {

        $permissions = Permission::all();
        $rolePermission = Role::with('rolePermission.permissionName')->get();

        return view('admin.permission.rolePermission', compact(['rolePermission', 'permissions']));
    }

    public function assignPermissionRole(Request $request)
    {

        $permissions = $request->get('permissions');

        $roleID = $request->update_id;
        $check = RolePermission::where('role_id', $roleID)->where('perm_id', 2)->exists();


        foreach ($permissions as $permission) {
            $check = RolePermission::where('role_id', $roleID)->where('perm_id', $permission)->exists();

            //false if does not exists

            if ($check == FALSE) {
                $updatePermission = new RolePermission();
                $updatePermission->role_id = $roleID;
                $updatePermission->perm_id = $permission;
                $updatePermission->save();
                return redirect()->route('admin.role.permission')->with('success', 'Permissions updated Successfully');
            } else {
                return redirect()->route('admin.role.permission')->with('error', 'Permissions already Exists');
            }
        }
    }
}
