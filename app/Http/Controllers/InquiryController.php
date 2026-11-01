<?php

namespace App\Http\Controllers;

use App\Mail\NewInquiryReceived;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class InquiryController extends Controller
{
    /**
     * Store a general contact inquiry.
     */
    public function storeContact(Request $request)
    {
        if ($request->filled('_honeypot')) {
            return Redirect::back()->with('success', 'Thank you! Your message has been sent successfully.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        $inquiry = Inquiry::create([
            'type' => 'contact',
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'service' => $validated['subject'] ?? 'General Inquiry',
            'message' => $validated['message'],
            'status' => 'new',
        ]);

        try {
            $adminEmail = config('mail.from.address', 'admin@softpolli.com');
            Mail::to($adminEmail)->send(new NewInquiryReceived($inquiry));
        } catch (\Throwable $e) {
            Log::error('Failed to dispatch contact inquiry notification: ' . $e->getMessage());
        }

        return Redirect::back()->with('success', 'Thank you! Your message has been sent successfully. Our team will contact you shortly.');
    }

    /**
     * Store a dynamic multi-step quote request.
     */
    public function storeQuote(Request $request)
    {
        if ($request->filled('_honeypot')) {
            return Redirect::back()->with('success', 'Quote request submitted!');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'company' => 'nullable|string|max:255',
            'service' => 'required|string|max:255',
            'selected_features' => 'nullable|array',
            'selected_features.*' => 'string|max:150',
            'budget_range' => 'nullable|string|max:100',
            'timeline' => 'nullable|string|max:100',
            'message' => 'nullable|string|max:5000',
        ]);

        $inquiry = Inquiry::create([
            'type' => 'quote',
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'company' => $validated['company'] ?? null,
            'service' => $validated['service'],
            'selected_features' => $validated['selected_features'] ?? [],
            'budget_range' => $validated['budget_range'] ?? null,
            'timeline' => $validated['timeline'] ?? null,
            'message' => $validated['message'] ?? '',
            'status' => 'new',
        ]);

        try {
            $adminEmail = config('mail.from.address', 'admin@softpolli.com');
            Mail::to($adminEmail)->send(new NewInquiryReceived($inquiry));
        } catch (\Throwable $e) {
            Log::error('Failed to dispatch quote inquiry notification: ' . $e->getMessage());
        }

        return Redirect::back()->with('success', 'Quote request submitted! We have received your specifications and will provide a tailored estimate soon.');
    }
}
