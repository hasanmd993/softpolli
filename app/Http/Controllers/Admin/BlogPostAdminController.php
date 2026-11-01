<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class BlogPostAdminController extends Controller
{
    public function index(Request $request): Response
    {
        $query = BlogPost::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $posts = $query->orderByDesc('id')->get();

        return Inertia::render('Admin/BlogPosts', [
            'posts' => $posts,
            'filters' => $request->only(['search']),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_posts,slug',
            'category' => 'required|string|max:100',
            'read_time' => 'nullable|string|max:50',
            'date' => 'nullable|string|max:50',
            'excerpt' => 'required|string',
            'image' => 'required|string|max:255',
            'author' => 'required|string|max:100',
            'is_published' => 'nullable|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = BlogPost::generateUniqueSlug($validated['title']);
        }

        $validated['read_time'] = $validated['read_time'] ?? '5 min read';
        $validated['date'] = $validated['date'] ?? now()->format('M d, Y');
        $validated['is_published'] = $request->boolean('is_published', true);

        BlogPost::create($validated);

        return back()->with('success', "Blog post '{$validated['title']}' created successfully.");
    }

    public function update(Request $request, BlogPost $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_posts,slug,'.$post->id,
            'category' => 'required|string|max:100',
            'read_time' => 'nullable|string|max:50',
            'date' => 'nullable|string|max:50',
            'excerpt' => 'required|string',
            'image' => 'required|string|max:255',
            'author' => 'required|string|max:100',
            'is_published' => 'nullable|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = BlogPost::generateUniqueSlug($validated['title'], $post->id);
        }

        $validated['read_time'] = $validated['read_time'] ?? $post->read_time;
        $validated['date'] = $validated['date'] ?? $post->date;
        $validated['is_published'] = $request->boolean('is_published');

        $post->update($validated);

        return back()->with('success', "Blog post '{$post->title}' updated successfully.");
    }

    public function toggle(BlogPost $post)
    {
        $post->update(['is_published' => !$post->is_published]);

        $status = $post->is_published ? 'published' : 'drafted';
        return back()->with('success', "Blog post '{$post->title}' is now {$status}.");
    }

    public function destroy(BlogPost $post)
    {
        $title = $post->title;
        $post->delete();

        return back()->with('success', "Blog post '{$title}' deleted successfully.");
    }
}
