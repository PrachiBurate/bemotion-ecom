<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::latest()->get();
        return view('admin.teams.index', compact('teams'));
    }

    public function store(Request $request)
    {
        $this->authorizeAction('teams.create');

        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'position'  => ['nullable', 'string', 'max:255'],
            'image'     => ['required', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'facebook'  => ['nullable', 'url', 'max:255'],
            'linkedin'  => ['nullable', 'url', 'max:255'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'twitter'   => ['nullable', 'url', 'max:255'],
            'status'    => ['nullable', 'in:0,1'],
        ], [
            'name.required'    => 'Name is required.',
            'image.required'   => 'Please upload an image.',
            'image.image'      => 'The file must be an image.',
            'image.mimes'      => 'Image must be jpg, jpeg, png, or webp.',
            'image.max'        => 'Image may not be larger than 2MB.',
            'facebook.url'     => 'Facebook must be a valid URL.',
            'linkedin.url'     => 'LinkedIn must be a valid URL.',
            'instagram.url'    => 'Instagram must be a valid URL.',
            'twitter.url'      => 'Twitter must be a valid URL.',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/team'), $imageName);
        }

        Team::create([
            'name'      => $validated['name'],
            'position'  => $validated['position'] ?? null,
            'image'     => $imageName,
            'facebook'  => $validated['facebook'] ?? null,
            'linkedin'  => $validated['linkedin'] ?? null,
            'instagram' => $validated['instagram'] ?? null,
            'twitter'   => $validated['twitter'] ?? null,
            'status'    => $validated['status'] ?? 1,
        ]);

        return back()->with('success', 'Team Added');
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAction('teams.edit');

        $team = Team::findOrFail($id);

        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'position'  => ['nullable', 'string', 'max:255'],
            'image'     => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'facebook'  => ['nullable', 'url', 'max:255'],
            'linkedin'  => ['nullable', 'url', 'max:255'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'twitter'   => ['nullable', 'url', 'max:255'],
            'status'    => ['nullable', 'in:0,1'],
        ], [
            'name.required' => 'Name is required.',
            'image.image'   => 'The file must be an image.',
            'image.mimes'   => 'Image must be jpg, jpeg, png, or webp.',
            'image.max'     => 'Image may not be larger than 2MB.',
            'facebook.url'  => 'Facebook must be a valid URL.',
            'linkedin.url'  => 'LinkedIn must be a valid URL.',
            'instagram.url' => 'Instagram must be a valid URL.',
            'twitter.url'   => 'Twitter must be a valid URL.',
        ]);

        $data = [
            'name'      => $validated['name'],
            'position'  => $validated['position'] ?? null,
            'facebook'  => $validated['facebook'] ?? null,
            'linkedin'  => $validated['linkedin'] ?? null,
            'instagram' => $validated['instagram'] ?? null,
            'twitter'   => $validated['twitter'] ?? null,
            'status'    => $validated['status'] ?? $team->status,
        ];

        if ($request->hasFile('image')) {

            if ($team->image && file_exists(public_path('assets/images/team/' . $team->image))) {
                @unlink(public_path('assets/images/team/' . $team->image));
            }

            $file = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/team'), $imageName);

            $data['image'] = $imageName;
        }

        $team->update($data);

        return back()->with('success', 'Updated');
    }

    public function delete($id)
    {
        $this->authorizeAction('teams.delete');

        $team = Team::findOrFail($id);

        if ($team->image && file_exists(public_path('assets/images/team/' . $team->image))) {
            @unlink(public_path('assets/images/team/' . $team->image));
        }

        $team->delete();

        return back()->with('success', 'Deleted');
    }

    private function authorizeAction(string $permission): void
    {
        $user = auth()->user();

        if (!$user || !($user->hasPermission($permission) || $user->is_admin)) {
            abort(403, 'You are not authorized to perform this action.');
        }
    }
}