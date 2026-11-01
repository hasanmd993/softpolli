<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class InquiryAdminController extends Controller
{
    /**
     * Display a listing of client inquiries and quote requests.
     */
    public function index(Request $request): Response
    {
        $query = Inquiry::query();

        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $inquiries = $query->latest()->paginate(15)->withQueryString();

        return Inertia::render('Admin/Inquiries', [
            'inquiries' => $inquiries,
            'filters' => $request->only(['type', 'status']),
        ]);
    }

    /**
     * Update the status of an inquiry.
     */
    public function updateStatus(Request $request, Inquiry $inquiry)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,reviewed,contacted,closed',
        ]);

        $inquiry->update(['status' => $validated['status']]);

        return back()->with('success', "Inquiry #{$inquiry->id} status updated to {$validated['status']}.");
    }

    /**
     * Delete an inquiry.
     */
    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();

        return back()->with('success', "Inquiry #{$inquiry->id} deleted successfully.");
    }
}
