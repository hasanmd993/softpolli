<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryAdminController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'nullable|string|max:50',
            'icon' => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);

        $type = $validated['type'] ?? 'service';
        $slug = Str::slug($validated['name']);

        // Check if exists
        $existing = Category::where('slug', $slug)->where('type', $type)->first();
        if ($existing) {
            return back()->with('info', "Category '{$existing->name}' already exists.");
        }

        $category = Category::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'type' => $type,
            'icon' => $validated['icon'] ?? 'fa-solid fa-cube',
            'description' => $validated['description'] ?? null,
            'sort_order' => Category::where('type', $type)->count() + 1,
            'is_active' => true,
        ]);

        return back()->with('success', "Category '{$category->name}' created successfully.");
    }
}
