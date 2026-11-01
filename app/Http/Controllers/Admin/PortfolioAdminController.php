<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioProject;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class PortfolioAdminController extends Controller
{
    public function index(Request $request): Response
    {
        $query = PortfolioProject::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('tagline', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $projects = $query->orderBy('sort_order')->orderBy('id')->get();

        return Inertia::render('Admin/Portfolio', [
            'projects' => $projects,
            'filters' => $request->only(['search']),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => 'nullable|string|max:10',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:portfolio_projects,slug',
            'category' => 'required|string|max:100',
            'tagline' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|string|max:255',
            'live_url' => 'nullable|string|max:255',
            'metrics' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = PortfolioProject::generateUniqueSlug($validated['title']);
        }

        if (empty($validated['number'])) {
            $count = PortfolioProject::count() + 1;
            $validated['number'] = str_pad($count, 2, '0', STR_PAD_LEFT);
        }

        $validated['live_url'] = $validated['live_url'] ?? '#';
        $validated['is_featured'] = $request->boolean('is_featured', true);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        PortfolioProject::create($validated);

        return back()->with('success', "Project '{$validated['title']}' created successfully.");
    }

    public function update(Request $request, PortfolioProject $project)
    {
        $validated = $request->validate([
            'number' => 'nullable|string|max:10',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:portfolio_projects,slug,'.$project->id,
            'category' => 'required|string|max:100',
            'tagline' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|string|max:255',
            'live_url' => 'nullable|string|max:255',
            'metrics' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = PortfolioProject::generateUniqueSlug($validated['title'], $project->id);
        }

        $validated['number'] = $validated['number'] ?? $project->number;
        $validated['live_url'] = $validated['live_url'] ?? '#';
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['sort_order'] = $validated['sort_order'] ?? $project->sort_order;

        $project->update($validated);

        return back()->with('success', "Project '{$project->title}' updated successfully.");
    }

    public function toggle(PortfolioProject $project)
    {
        $project->update(['is_featured' => !$project->is_featured]);

        $status = $project->is_featured ? 'featured' : 'unfeatured';
        return back()->with('success', "Project '{$project->title}' is now {$status}.");
    }

    public function destroy(PortfolioProject $project)
    {
        $title = $project->title;
        $project->delete();

        return back()->with('success', "Project '{$title}' deleted successfully.");
    }
}
