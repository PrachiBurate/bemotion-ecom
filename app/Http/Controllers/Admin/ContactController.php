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
    $queries = ContactQuery::latest()->get();
    return view('admin.contact_queries.index', compact('queries'));
}

public function updateContactStatus($id)
{
    $q = ContactQuery::findOrFail($id);
    $q->status = 1;
    $q->save();

    return back();
}

public function deleteContact($id)
{
    ContactQuery::findOrFail($id)->delete();
    return back()->with('success', 'Deleted');
}


}