<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TeamMemberAdminController extends Controller
{
    public function index(Request $request): Response
    {
        $query = TeamMember::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%");
            });
        }

        $members = $query->orderBy('sort_order')->orderBy('id')->get();

        return Inertia::render('Admin/TeamMembers', [
            'members' => $members,
            'filters' => $request->only(['search']),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'role' => 'required|string|max:150',
            'image' => 'required|string|max:255',
            'social' => 'nullable|array',
            'social.linkedin' => 'nullable|string|max:255',
            'social.github' => 'nullable|string|max:255',
            'social.twitter' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        TeamMember::create($validated);

        return back()->with('success', "Team member '{$validated['name']}' added successfully.");
    }

    public function update(Request $request, TeamMember $teamMember)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'role' => 'required|string|max:150',
            'image' => 'required|string|max:255',
            'social' => 'nullable|array',
            'social.linkedin' => 'nullable|string|max:255',
            'social.github' => 'nullable|string|max:255',
            'social.twitter' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? $teamMember->sort_order;

        $teamMember->update($validated);

        return back()->with('success', "Team member '{$teamMember->name}' updated successfully.");
    }

    public function destroy(TeamMember $teamMember)
    {
        $name = $teamMember->name;
        $teamMember->delete();

        return back()->with('success', "Team member '{$name}' deleted successfully.");
    }
}
