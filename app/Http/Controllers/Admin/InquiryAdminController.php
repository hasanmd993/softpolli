<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Rap2hpoutre\FastExcel\FastExcel;

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

    /**
     * Export inquiries to Excel.
     */
    public function export()
    {
        return (new FastExcel(Inquiry::latest()->get()))->download('softpolli-inquiries-' . date('Y-m-d') . '.xlsx', function ($inquiry) {
            return [
                'ID' => $inquiry->id,
                'Type' => ucfirst($inquiry->type),
                'Name' => $inquiry->name,
                'Email' => $inquiry->email,
                'Phone' => $inquiry->phone ?? 'N/A',
                'Company' => $inquiry->company ?? 'N/A',
                'Service' => $inquiry->service ?? 'N/A',
                'Budget' => $inquiry->budget_range ?? 'N/A',
                'Timeline' => $inquiry->timeline ?? 'N/A',
                'Status' => ucfirst($inquiry->status),
                'Message' => $inquiry->message ?? '',
                'Created At' => $inquiry->created_at?->format('Y-m-d H:i') ?? '',
            ];
        });
    }

    /**
     * Download branded PDF summary of an inquiry.
     */
    public function downloadPdf(Inquiry $inquiry)
    {
        $pdf = Pdf::loadView('pdf.inquiry', compact('inquiry'));
        return $pdf->download("softpolli-inquiry-{$inquiry->id}.pdf");
    }
}
