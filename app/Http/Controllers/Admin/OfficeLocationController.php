<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OfficeLocation;

class OfficeLocationController extends Controller
{
    // ================= LIST =================
    public function index()
    {
        $offices = OfficeLocation::latest()->get();
        return view('admin.office_locations.index', compact('offices'));
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'address' => 'required',
            'phone1' => 'required',
            'email' => 'required|email'
        ]);

        OfficeLocation::create([
            'title'   => $request->title,
            'address' => $request->address,
            'phone1'  => $request->phone1,
            'phone2'  => $request->phone2,
            'email'   => $request->email,
            'status'  => 1
        ]);

        return back()->with('success', 'Office added successfully!');
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'address' => 'required',
            'phone1' => 'required',
            'email' => 'required|email'
        ]);

        $office = OfficeLocation::findOrFail($id);

        $office->update([
            'title'   => $request->title,
            'address' => $request->address,
            'phone1'  => $request->phone1,
            'phone2'  => $request->phone2,
            'email'   => $request->email,
            'status'  => $request->status ?? 1
        ]);

        return back()->with('success', 'Office updated successfully!');
    }

    // ================= DELETE =================
    public function delete($id)
    {
        OfficeLocation::findOrFail($id)->delete();
        return back()->with('success', 'Office deleted successfully!');
    }
}