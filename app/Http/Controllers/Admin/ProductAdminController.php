<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class ProductAdminController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query->orderBy('sort_order')->orderBy('id')->get();

        return Inertia::render('Admin/Products', [
            'products' => $products,
            'filters' => $request->only(['search']),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:100',
            'bg' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Product::generateUniqueSlug($validated['title']);
        }

        $validated['icon'] = $validated['icon'] ?? 'fa-gear';
        $validated['bg'] = $validated['bg'] ?? '#E8E4FF';
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Product::create($validated);

        return back()->with('success', "Product '{$validated['title']}' created successfully.");
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,'.$product->id,
            'description' => 'required|string',
            'icon' => 'nullable|string|max:100',
            'bg' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Product::generateUniqueSlug($validated['title'], $product->id);
        }

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? $product->sort_order;

        $product->update($validated);

        return back()->with('success', "Product '{$product->title}' updated successfully.");
    }

    public function toggle(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);

        $status = $product->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Product '{$product->title}' has been {$status}.");
    }

    public function destroy(Product $product)
    {
        $title = $product->title;
        $product->delete();

        return back()->with('success', "Product '{$title}' deleted successfully.");
    }
}
