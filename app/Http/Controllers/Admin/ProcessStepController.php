<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProcessStep;
use Illuminate\Http\Request;

class ProcessStepController extends Controller
{
    public function index()
    {
        $steps = ProcessStep::orderBy('step_number')->get();
        return view('admin.process_steps.index', compact('steps'));
    }

    public function store(Request $request)
    {
        ProcessStep::create($request->all());
        return back()->with('success', 'Step added successfully');
    }

    public function update(Request $request, $id)
    {
        ProcessStep::find($id)->update($request->all());
        return back()->with('success', 'Step updated');
    }

    public function delete($id)
    {
        ProcessStep::find($id)->delete();
        return back()->with('success', 'Step deleted');
    }
}