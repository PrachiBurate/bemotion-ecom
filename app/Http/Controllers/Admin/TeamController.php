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
        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('assets/images/team'), $name);
            $data['image'] = $name;
        }

        Team::create($data);

        return back()->with('success','Team Added');
    }

    public function update(Request $request, $id)
    {
        $team = Team::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('image')) {

            if ($team->image && file_exists(public_path('assets/images/team/'.$team->image))) {
                unlink(public_path('assets/images/team/'.$team->image));
            }

            $file = $request->file('image');
            $name = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('assets/images/team'), $name);
            $data['image'] = $name;
        }

        $team->update($data);

        return back()->with('success','Updated');
    }

    public function delete($id)
    {
        $team = Team::findOrFail($id);

        if ($team->image && file_exists(public_path('assets/images/team/'.$team->image))) {
            unlink(public_path('assets/images/team/'.$team->image));
        }

        $team->delete();

        return back()->with('success','Deleted');
    }
}