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
        $this->authorizeAction('process_steps.create');

        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'icon'        => ['required', 'string', 'max:100', 'regex:/^fa-[a-z0-9-]+$/'],
            'step_number' => ['nullable', 'integer', 'min:0'],
            'status'      => ['nullable', 'in:0,1'],
        ], [
            'title.required' => 'Title is required.',
            'icon.required'  => 'Please select an icon.',
            'icon.regex'     => 'Invalid icon selected.',
        ]);

        ProcessStep::create([
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'icon'        => $validated['icon'],
            'step_number' => $validated['step_number'] ?? 0,
            'status'      => $validated['status'] ?? 1,
        ]);

        return back()->with('success', 'Step added successfully');
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAction('process_steps.edit');

        $step = ProcessStep::findOrFail($id);

        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'icon'        => ['required', 'string', 'max:100', 'regex:/^fa-[a-z0-9-]+$/'],
            'step_number' => ['nullable', 'integer', 'min:0'],
            'status'      => ['nullable', 'in:0,1'],
        ], [
            'title.required' => 'Title is required.',
            'icon.required'  => 'Please select an icon.',
            'icon.regex'     => 'Invalid icon selected.',
        ]);

        $step->update([
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'icon'        => $validated['icon'],
            'step_number' => $validated['step_number'] ?? $step->step_number,
            'status'      => $validated['status'] ?? $step->status,
        ]);

        return back()->with('success', 'Step updated');
    }

    public function delete($id)
    {
        $this->authorizeAction('process_steps.delete');

        $step = ProcessStep::findOrFail($id);
        $step->delete();

        return back()->with('success', 'Step deleted');
    }

    private function authorizeAction(string $permission): void
    {
        $user = auth()->user();

        if (!$user || !($user->hasPermission($permission) || $user->is_admin)) {
            abort(403, 'You are not authorized to perform this action.');
        }
    }
}