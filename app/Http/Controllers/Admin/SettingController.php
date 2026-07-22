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
        $setting = Setting::first();

        // LOGO UPLOAD
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $logo = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('assets/images/logo'), $logo);
        } else {
            $logo = $setting->logo ?? null;
        }

        if (!$setting) {
            Setting::create([
                'site_name' => $request->site_name,
                'slogan' => $request->slogan,
                'logo' => $logo,
                'contact_number' => $request->contact_number,
                'email' => $request->email,
                'facebook_url' => $request->facebook_url,
                'instagram_url' => $request->instagram_url,
                'linkedin_url' => $request->linkedin_url,
                'twitter_url' => $request->twitter_url,
            ]);
        } else {
            $setting->update([
                'site_name' => $request->site_name,
                'slogan' => $request->slogan,
                'logo' => $logo,
                'contact_number' => $request->contact_number,
                'email' => $request->email,
                'facebook_url' => $request->facebook_url,
                'instagram_url' => $request->instagram_url,
                'linkedin_url' => $request->linkedin_url,
                'twitter_url' => $request->twitter_url,
            ]);
        }

        return back()->with('success', 'Settings Updated Successfully');
    }
}