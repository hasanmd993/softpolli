<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SettingAdminController extends Controller
{
    /**
     * Display the site settings manager page.
     */
    public function index(): Response
    {
        $settings = Setting::all();

        return Inertia::render('Admin/Settings', [
            'settings' => $settings,
            'groupedSettings' => $settings->groupBy('group'),
        ]);
    }

    /**
     * Update site settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*' => 'nullable',
        ]);

        Setting::setMany($validated['settings']);

        activity('admin')
            ->causedBy($request->user())
            ->log('Updated system and site settings');

        return redirect()->back()->with('success', 'Site settings updated successfully.');
    }
}

