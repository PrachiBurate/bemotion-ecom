<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactQuery;
use App\Models\OfficeLocation;

class ContactController extends Controller
{
    public function contactQueries()
    {
        $user = auth()->user();

        abort_unless($user->hasPermission('contact_queries.view') || $user->is_admin, 403);

        $queries = ContactQuery::latest()->get();
        return view('admin.contact_queries.index', compact('queries'));
    }

    public function updateContactStatus($id)
    {
        $user = auth()->user();

        abort_unless($user->hasPermission('contact_queries.update') || $user->is_admin, 403);

        $q = ContactQuery::find($id);

        if (!$q) {
            return back()->with('error', 'Query not found.');
        }

        $q->status = 1;
        $q->save();

        return back()->with('success', 'Marked as read');
    }

    public function deleteContact($id)
    {
        $user = auth()->user();

        abort_unless($user->hasPermission('contact_queries.delete') || $user->is_admin, 403);

        $q = ContactQuery::find($id);

        if (!$q) {
            return back()->with('error', 'Query not found.');
        }

        $q->delete();

        return back()->with('success', 'Deleted successfully');
    }
}