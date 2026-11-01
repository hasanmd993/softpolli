<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PricingPlan;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PricingPlanAdminController extends Controller
{
    public function index(Request $request): Response
    {
        $plans = PricingPlan::orderBy('sort_order')->orderBy('id')->get();

        return Inertia::render('Admin/PricingPlans', [
            'plans' => $plans,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'audience' => 'required|string|max:255',
            'monthly_price' => 'required|numeric|min:0',
            'annual_price' => 'required|numeric|min:0',
            'is_popular' => 'nullable|boolean',
            'features' => 'required',
            'sort_order' => 'nullable|integer',
        ]);

        if (is_string($validated['features'])) {
            $validated['features'] = array_values(array_filter(array_map('trim', explode("\n", $validated['features']))));
        }

        $validated['is_popular'] = $request->boolean('is_popular');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        PricingPlan::create($validated);

        return back()->with('success', "Pricing plan '{$validated['name']}' created successfully.");
    }

    public function update(Request $request, PricingPlan $plan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'audience' => 'required|string|max:255',
            'monthly_price' => 'required|numeric|min:0',
            'annual_price' => 'required|numeric|min:0',
            'is_popular' => 'nullable|boolean',
            'features' => 'required',
            'sort_order' => 'nullable|integer',
        ]);

        if (is_string($validated['features'])) {
            $validated['features'] = array_values(array_filter(array_map('trim', explode("\n", $validated['features']))));
        }

        $validated['is_popular'] = $request->boolean('is_popular');
        $validated['sort_order'] = $validated['sort_order'] ?? $plan->sort_order;

        $plan->update($validated);

        return back()->with('success', "Pricing plan '{$plan->name}' updated successfully.");
    }

    public function toggle(PricingPlan $plan)
    {
        $plan->update(['is_popular' => !$plan->is_popular]);

        $status = $plan->is_popular ? 'marked as popular' : 'unmarked';
        return back()->with('success', "Plan '{$plan->name}' {$status}.");
    }

    public function destroy(PricingPlan $plan)
    {
        $name = $plan->name;
        $plan->delete();

        return back()->with('success', "Pricing plan '{$name}' deleted successfully.");
    }
}
