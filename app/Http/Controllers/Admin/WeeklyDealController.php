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
        $this->authorizeAction('weekly_deals.create');

        $validated = $request->validate([
            'title'    => ['required', 'string', 'max:255'],
            'discount' => ['nullable', 'string', 'max:50'],
            'end_date' => ['nullable', 'date', 'after_or_equal:today'],
            'status'   => ['nullable', 'in:0,1'],
            'image'    => ['required', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'title.required'        => 'Title is required.',
            'end_date.date'         => 'Please provide a valid end date.',
            'end_date.after_or_equal' => 'End date cannot be in the past.',
            'image.required'        => 'Please upload an image.',
            'image.image'           => 'The file must be an image.',
            'image.mimes'           => 'Image must be jpg, jpeg, png, or webp.',
            'image.max'             => 'Image may not be larger than 2MB.',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/banner'), $imageName);
        }

        WeeklyDeal::create([
            'title'    => $validated['title'],
            'discount' => $validated['discount'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'status'   => $validated['status'] ?? 1,
            'image'    => $imageName,
        ]);

        return back()->with('success', 'Weekly Deal Added');
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $this->authorizeAction('weekly_deals.edit');

        $deal = WeeklyDeal::findOrFail($id);

        $validated = $request->validate([
            'title'    => ['required', 'string', 'max:255'],
            'discount' => ['nullable', 'string', 'max:50'],
            'end_date' => ['nullable', 'date'],
            'status'   => ['nullable', 'in:0,1'],
            'image'    => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'title.required' => 'Title is required.',
            'end_date.date'  => 'Please provide a valid end date.',
            'image.image'    => 'The file must be an image.',
            'image.mimes'    => 'Image must be jpg, jpeg, png, or webp.',
            'image.max'      => 'Image may not be larger than 2MB.',
        ]);

        $data = [
            'title'    => $validated['title'],
            'discount' => $validated['discount'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'status'   => $validated['status'] ?? $deal->status,
        ];

        if ($request->hasFile('image')) {

            if ($deal->image && file_exists(public_path('assets/images/banner/' . $deal->image))) {
                @unlink(public_path('assets/images/banner/' . $deal->image));
            }

            $file = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/banner'), $imageName);

            $data['image'] = $imageName;
        }

        $deal->update($data);

        return back()->with('success', 'Weekly Deal Updated');
    }

    // ================= DELETE =================
    public function delete($id)
    {
        $this->authorizeAction('weekly_deals.delete');

        $deal = WeeklyDeal::findOrFail($id);

        if ($deal->image && file_exists(public_path('assets/images/banner/' . $deal->image))) {
            @unlink(public_path('assets/images/banner/' . $deal->image));
        }

        $deal->delete();

        return back()->with('success', 'Weekly Deal Deleted');
    }

    /**
     * Shared server-side permission check.
     */
    private function authorizeAction(string $permission): void
    {
        $user = auth()->user();

        if (!$user || !($user->hasPermission($permission) || $user->is_admin)) {
            abort(403, 'You are not authorized to perform this action.');
        }
    }
}