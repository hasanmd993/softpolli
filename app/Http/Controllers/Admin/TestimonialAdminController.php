<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TestimonialAdminController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Testimonial::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('quote', 'like', "%{$search}%");
            });
        }

        $testimonials = $query->orderBy('sort_order')->orderBy('id')->get();

        return Inertia::render('Admin/Testimonials', [
            'testimonials' => $testimonials,
            'filters' => $request->only(['search']),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'designation' => 'required|string|max:150',
            'company' => 'required|string|max:150',
            'category' => 'required|string|max:100',
            'quote' => 'required|string',
            'src' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Testimonial::create($validated);

        return back()->with('success', "Testimonial from '{$validated['name']}' created successfully.");
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'designation' => 'required|string|max:150',
            'company' => 'required|string|max:150',
            'category' => 'required|string|max:100',
            'quote' => 'required|string',
            'src' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? $testimonial->sort_order;

        $testimonial->update($validated);

        return back()->with('success', "Testimonial from '{$testimonial->name}' updated successfully.");
    }

    public function destroy(Testimonial $testimonial)
    {
        $name = $testimonial->name;
        $testimonial->delete();

        return back()->with('success', "Testimonial from '{$name}' deleted successfully.");
    }
}
