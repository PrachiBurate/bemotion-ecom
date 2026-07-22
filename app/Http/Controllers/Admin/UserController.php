<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // 🔥 LIST USERS
    public function index()
    {
        $users = User::with('role')
                    ->where('is_admin', 0)
                    ->get();

        $roles = Role::all();

        return view('admin.users.index', compact('users','roles'));
    }

    // 🔥 CREATE USER
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role_id' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'username' => strtolower($request->username),
            'email' => $request->email,
            'password' => Hash::make($request->password), // 🔐 HASHED
            'role_id' => $request->role_id,
            'is_admin' => 0,
            'status' => 1
        ]);

        return back()->with('success', 'User Created Successfully');
    }

    // 🔥 UPDATE USER
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // ❌ Prevent admin edit
        if ($user->is_admin == 1) {
            return back()->with('error', 'Cannot edit admin');
        }

        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,'.$id,
            'email' => 'required|email|unique:users,email,'.$id,
            'role_id' => 'required',
            'password' => 'nullable|min:6' // 🔥 important
        ]);

        $data = [
            'name' => $request->name,
            'username' => strtolower($request->username),
            'email' => $request->email,
            'role_id' => $request->role_id
        ];

        // 🔥 Only update password if provided
        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'User Updated Successfully');
    }

    // 🔥 DELETE USER
    public function delete($id)
    {
        $user = User::findOrFail($id);

        // ❌ Prevent admin delete
        if ($user->is_admin == 1) {
            return back()->with('error', 'Cannot delete admin');
        }

        $user->delete();

        return back()->with('success', 'User Deleted Successfully');
    }
}