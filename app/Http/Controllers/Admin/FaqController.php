<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\FaqQuery;
use Illuminate\Validation\Rule;

class FaqController extends Controller
{
    /**
     * Validation rules shared between store/update.
     */
    private function rules($id = null)
    {
        return [
            'question' => [
                'required',
                'string',
                'min:5',
                'max:255',
                Rule::unique('faqs', 'question')->ignore($id),
            ],
            'answer' => [
                'required',
                'string',
                'min:5',
                'max:2000',
            ],
            'status' => [
                'required',
                'in:0,1',
            ],
        ];
    }

    private function messages()
    {
        return [
            'question.required' => 'Question is required.',
            'question.min' => 'Question must be at least 5 characters.',
            'question.max' => 'Question may not exceed 255 characters.',
            'question.unique' => 'This question already exists.',
            'answer.required' => 'Answer is required.',
            'answer.min' => 'Answer must be at least 5 characters.',
            'answer.max' => 'Answer may not exceed 2000 characters.',
            'status.required' => 'Please select a status.',
            'status.in' => 'Status must be either Active or Inactive.',
        ];
    }

    public function index()
    {
        $faqs = Faq::latest()->get();
        return view('admin.faqs.index', compact('faqs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules(), $this->messages());

        Faq::create($validated);

        return back()->with('success', 'FAQ Added Successfully');
    }

    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);

        $validated = $request->validate($this->rules($id), $this->messages());

        $faq->update($validated);

        return back()->with('success', 'FAQ Updated Successfully');
    }

    public function delete($id)
    {
        Faq::findOrFail($id)->delete();

        return back()->with('success', 'FAQ Deleted Successfully');
    }

    public function faqQueries()
    {
        $queries = FaqQuery::latest()->get();
        return view('admin.faq_queries.index', compact('queries'));
    }

    public function deleteFaqQuery($id)
    {
        FaqQuery::findOrFail($id)->delete();
        return back()->with('success', 'Deleted successfully');
    }

    public function updateFaqQueryStatus($id)
    {
        $query = FaqQuery::findOrFail($id);
        $query->status = 1;
        $query->save();

        return back()->with('success', 'Marked as read');
    }
}