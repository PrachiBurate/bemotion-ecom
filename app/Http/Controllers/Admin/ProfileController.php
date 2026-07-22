<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
class ProfileController extends Controller
{
    public function passwordForm()
    {
        return view('admin.profile.change-password');
    }

  public function changePassword(Request $request)
{
    $request->validate([
        'old_password' => ['required'],

        'new_password' => [
            'required',
            'different:old_password',
            Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols(),
        ],

        'confirm_password' => [
            'required',
            'same:new_password',
        ],
    ], [
        'old_password.required' => 'Please enter your current password.',
        'new_password.required' => 'Please enter a new password.',
        'new_password.different' => 'New password must be different from your current password.',
        'confirm_password.required' => 'Please confirm your new password.',
        'confirm_password.same' => 'Confirm password does not match.',
    ]);

    $user = auth()->user();

    if (!Hash::check($request->old_password, $user->password)) {
        throw ValidationException::withMessages([
            'old_password' => ['The current password is incorrect.'],
        ]);
    }

    $user->password = Hash::make($request->new_password);
    $user->save();

    return back()->with('success', 'Password changed successfully.');
}
}