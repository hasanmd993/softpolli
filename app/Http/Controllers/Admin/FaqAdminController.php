<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class FaqAdminController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Faq::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                  ->orWhere('answer', 'like', "%{$search}%");
            });
        }

        $faqs = $query->orderBy('sort_order')->orderBy('id')->get();

        return Inertia::render('Admin/Faqs', [
            'faqs' => $faqs,
            'filters' => $request->only(['search']),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Faq::create($validated);

        return back()->with('success', 'FAQ created successfully.');
    }

    public function update(Request $request, Faq $faq)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? $faq->sort_order;

        $faq->update($validated);

        return back()->with('success', 'FAQ updated successfully.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return back()->with('success', 'FAQ deleted successfully.');
    }
}
