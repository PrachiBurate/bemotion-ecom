<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 🔥 Show Login Page
    public function showLogin()
    {
        return view('admin.login');
    }

    // 🔥 LOGIN FUNCTION
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // Attempt Login
        if (Auth::attempt([
            'username' => $request->username,
            'password' => $request->password
        ])) {

         $user = Auth::user();

//   force reload relations properly
$user->load('role.permissions');

//    dd(
//             $user->role->name,
//             $user->role->permissions->pluck('slug')->toArray()
//         );

            //   Check active user
            if ($user->status == 0) {
                Auth::logout();
                return back()->with('error', 'Your account is inactive');
            }

            //   Admin always allowed
            if ($user->is_admin == 1) {
                return redirect('/dashboard');
            }

            //   Check permission (IMPORTANT)
            if ($user->hasPermission('dashboard.view')) {
                return redirect('/dashboard');
            }

            // ❌ No permission
            Auth::logout();
            return back()->with('error', 'You do not have access to dashboard');
        }

        return back()->with('error', 'Invalid username or password');
    }

    // 🔥 LOGOUT
    public function logout()
    {
        Auth::logout();
        return redirect('/admin/login');
    }
}