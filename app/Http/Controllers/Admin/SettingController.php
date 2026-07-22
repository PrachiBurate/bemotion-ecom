<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();

        return view('admin.settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        // Permission check (server-side, not just hiding the button in Blade)
        if (!$user || !($user->hasPermission('settings.update') || $user->is_admin)) {
            abort(403, 'You are not authorized to update settings.');
        }

        $validated = $request->validate([
            'site_name'      => ['required', 'string', 'max:255'],
            'slogan'         => ['nullable', 'string', 'max:255'],
            'contact_number' => ['nullable', 'string', 'max:20'],
            'email'          => ['nullable', 'email', 'max:255'],
            'facebook_url'   => ['nullable', 'url', 'max:255'],
            'instagram_url'  => ['nullable', 'url', 'max:255'],
            'linkedin_url'   => ['nullable', 'url', 'max:255'],
            'twitter_url'    => ['nullable', 'url', 'max:255'],
            'logo'           => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'site_name.required' => 'The site name is required.',
            'email.email'        => 'Please enter a valid email address.',
            'logo.image'         => 'The logo must be an image file.',
            'logo.mimes'         => 'The logo must be a jpg, jpeg, png, or webp file.',
            'logo.max'           => 'The logo may not be larger than 2MB.',
        ]);

        $setting = Setting::first();

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $logo = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('assets/images/logo'), $logo);

            // Remove the old logo file if one exists
            if ($setting && $setting->logo && file_exists(public_path('assets/images/logo/'.$setting->logo))) {
                @unlink(public_path('assets/images/logo/'.$setting->logo));
            }
        } else {
            $logo = $setting->logo ?? null;
        }

        $data = collect($validated)->except('logo')->toArray();
        $data['logo'] = $logo;

        Setting::updateOrCreate(['id' => $setting->id ?? 0], $data);

        return back()->with('success', 'Settings Updated Successfully');
    }
}