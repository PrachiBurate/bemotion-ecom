<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    /**
     * Display roles list.
     */
    public function index()
    {
        abort_unless(auth()->user()->hasPermission('roles.view'), 403);

        $roles       = Role::with('permissions')->latest()->get();
        $permissions = Permission::orderBy('name')->get();

        return view('admin.roles.index', compact('roles', 'permissions'));
    }

    /**
     * Store a new role.
     */
    public function store(Request $request)
    {
        abort_unless(auth()->user()->hasPermission('roles.create'), 403);

        $validator = Validator::make($request->all(), $this->rules(), $this->messages());

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, 'store')
                ->withInput()
                ->with('open_modal', 'addRole');
        }

        $validated = $validator->validated();

        DB::transaction(function () use ($validated) {
            $role = Role::create([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
            ]);

            $role->permissions()->sync($validated['permissions']);
        });

        return back()->with('success', 'Role added successfully.');
    }

    /**
     * Update an existing role.
     */
    public function update(Request $request, Role $role)
    {
        abort_unless(auth()->user()->hasPermission('roles.edit'), 403);

        $validator = Validator::make($request->all(), $this->rules($role->id), $this->messages());

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, 'update_' . $role->id)
                ->withInput()
                ->with('open_modal', 'edit' . $role->id);
        }

        $validated = $validator->validated();

        DB::transaction(function () use ($role, $validated) {
            $role->update([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
            ]);

            $role->permissions()->sync($validated['permissions']);
        });

        return back()->with('success', 'Role updated successfully.');
    }

    /**
     * Delete a role (blocked if still assigned to users).
     */
    public function delete(Role $role)
    {
        abort_unless(auth()->user()->hasPermission('roles.delete'), 403);

        if ($role->users()->count() > 0) {
            return back()->with('error', 'This role is assigned to users and cannot be deleted.');
        }

        $role->delete();

        return back()->with('success', 'Role deleted successfully.');
    }

    /**
     * Shared validation rules for store/update.
     * $ignoreId lets update requests exclude their own row from the unique check.
     */
    private function rules($ignoreId = null): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:100',
                'regex:/^[A-Za-z ]+$/',
                'unique:roles,name' . ($ignoreId ? ',' . $ignoreId : ''),
            ],
            'permissions'   => ['required', 'array', 'min:1'],
            'permissions.*' => ['integer', 'exists:permissions,id'],
        ];
    }

    private function messages(): array
    {
        return [
            'name.required'        => 'Role name is required.',
            'name.regex'           => 'Role name should contain only letters and spaces.',
            'name.unique'          => 'This role already exists.',
            'name.max'             => 'Role name may not be longer than 100 characters.',
            'permissions.required' => 'Please select at least one permission.',
            'permissions.min'      => 'Please select at least one permission.',
            'permissions.*.exists' => 'One or more selected permissions are invalid.',
        ];
    }
}