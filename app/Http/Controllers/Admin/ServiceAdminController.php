<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class ServiceAdminController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Service::with('category');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('tag', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('category', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $services = $query->orderBy('sort_order')->orderBy('id')->get();
        $categories = Category::where('type', 'service')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return Inertia::render('Admin/Services', [
            'services' => $services,
            'categories' => $categories,
            'filters' => $request->only(['search']),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:services,slug',
            'description' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'tag' => 'nullable|string|max:100',
            'image' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Service::generateUniqueSlug($validated['title']);
        }

        if (!empty($validated['category_id'])) {
            $cat = Category::find($validated['category_id']);
            if ($cat) {
                $validated['tag'] = $cat->name;
            }
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Service::create($validated);

        return back()->with('success', "Service '{$validated['title']}' created successfully.");
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:services,slug,'.$service->id,
            'description' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'tag' => 'nullable|string|max:100',
            'image' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Service::generateUniqueSlug($validated['title'], $service->id);
        }

        if (!empty($validated['category_id'])) {
            $cat = Category::find($validated['category_id']);
            if ($cat) {
                $validated['tag'] = $cat->name;
            }
        }

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? $service->sort_order;

        $service->update($validated);

        return back()->with('success', "Service '{$service->title}' updated successfully.");
    }

    public function toggle(Service $service)
    {
        $service->update(['is_active' => !$service->is_active]);

        $status = $service->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Service '{$service->title}' has been {$status}.");
    }

    public function destroy(Service $service)
    {
        $title = $service->title;
        $service->delete();

        return back()->with('success', "Service '{$title}' deleted successfully.");
    }
}
