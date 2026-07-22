<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OfficeLocation;

class OfficeLocationController extends Controller
{
    /**
     * Validation rules shared between store/update.
     */
    private function rules()
    {
        return [
            'title' => [
                'required',
                'string',
                'max:150',
            ],
            'address' => [
                'required',
                'string',
                'max:500',
            ],
            'phone1' => [
                'required',
                'string',
                'regex:/^[0-9+\-\s()]{7,20}$/',
            ],
            'phone2' => [
                'nullable',
                'string',
                'regex:/^[0-9+\-\s()]{7,20}$/',
            ],
            'email' => [
                'required',
                'email',
                'max:150',
            ],
            'status' => [
                'required',
                'in:0,1',
            ],
        ];
    }

    private function messages()
    {
        return [
            'title.required' => 'Office title is required.',
            'address.required' => 'Office address is required.',
            'phone1.required' => 'Primary phone number is required.',
            'phone1.regex' => 'Please enter a valid phone number.',
            'phone2.regex' => 'Please enter a valid phone number.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'status.required' => 'Please select a status.',
            'status.in' => 'Status must be either Active or Inactive.',
        ];
    }

    // ================= LIST =================
    public function index()
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('office_locations.view') || $user->is_admin, 403);

        $offices = OfficeLocation::latest()->get();
        return view('admin.office_locations.index', compact('offices'));
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('office_locations.create') || $user->is_admin, 403);

        // status isn't in the Add modal's markup implicitly required client-side,
        // so default to Active if somehow missing rather than failing validation.
        $request->merge(['status' => $request->status ?? 1]);

        $validated = $request->validate($this->rules(), $this->messages());

        OfficeLocation::create($validated);

        return back()->with('success', 'Office added successfully!');
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('office_locations.edit') || $user->is_admin, 403);

        $office = OfficeLocation::findOrFail($id);

        $validated = $request->validate($this->rules(), $this->messages());

        $office->update($validated);

        return back()->with('success', 'Office updated successfully!');
    }

    // ================= DELETE =================
    public function delete($id)
    {
        $user = auth()->user();
        abort_unless($user->hasPermission('office_locations.delete') || $user->is_admin, 403);

        $office = OfficeLocation::find($id);

        if (!$office) {
            return back()->with('error', 'Office not found.');
        }

        $office->delete();

        return back()->with('success', 'Office deleted successfully!');
    }
}