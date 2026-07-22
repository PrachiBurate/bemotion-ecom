<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;
    use App\Models\FaqQuery;
class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::latest()->get();
        return view('admin.faqs.index', compact('faqs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required'
        ]);

        Faq::create($request->all());

        return back()->with('success', 'FAQ Added');
    }

    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);

        $faq->update($request->all());

        return back()->with('success', 'FAQ Updated');
    }

    public function delete($id)
    {
        Faq::findOrFail($id)->delete();

        return back()->with('success', 'FAQ Deleted');
    }


public function faqQueries()
{
    $queries = FaqQuery::latest()->get();
    return view('admin.faq_queries.index', compact('queries'));
}

// delete
public function deleteFaqQuery($id)
{
    FaqQuery::findOrFail($id)->delete();
    return back()->with('success', 'Deleted successfully');
}

// mark as read
public function updateFaqQueryStatus($id)
{
    $query = FaqQuery::findOrFail($id);
    $query->status = 1;
    $query->save();

    return back();
}
    
}