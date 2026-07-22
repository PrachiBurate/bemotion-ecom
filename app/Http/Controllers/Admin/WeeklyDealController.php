<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WeeklyDeal;

class WeeklyDealController extends Controller
{
    // ================= LIST =================
    public function index()
    {
        $weeklyDeals = WeeklyDeal::latest()->get();
        return view('admin.weekly-deals.index', compact('weeklyDeals'));
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $data = $request->all();

        // IMAGE UPLOAD
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/banner'), $name);

            $data['image'] = $name;
        }

        WeeklyDeal::create($data);

        return back()->with('success', 'Weekly Deal Added');
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $deal = WeeklyDeal::findOrFail($id);
        $data = $request->all();

        // IMAGE UPDATE
        if ($request->hasFile('image')) {

            // delete old image (optional but good)
            if ($deal->image && file_exists(public_path('assets/images/banner/' . $deal->image))) {
                unlink(public_path('assets/images/banner/' . $deal->image));
            }

            $file = $request->file('image');
            $name = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/banner'), $name);

            $data['image'] = $name;
        }

        $deal->update($data);

        return back()->with('success', 'Weekly Deal Updated');
    }

    // ================= DELETE =================
    public function delete($id)
    {
        $deal = WeeklyDeal::findOrFail($id);

        // delete image
        if ($deal->image && file_exists(public_path('assets/images/banner/' . $deal->image))) {
            unlink(public_path('assets/images/banner/' . $deal->image));
        }

        $deal->delete();

        return back()->with('success', 'Weekly Deal Deleted');
    }
}