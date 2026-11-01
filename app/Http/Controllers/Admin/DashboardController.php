<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Faq;
use App\Models\Inquiry;
use App\Models\PortfolioProject;
use App\Models\PricingPlan;
use App\Models\Product;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Display the main admin dashboard with real-time KPI metrics and visual analytics.
     */
    public function index(): Response
    {
        $startDate = now()->subMonths(5)->startOfMonth();
        $inquiryAggregates = Inquiry::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, type, count(*) as count")
            ->where('created_at', '>=', $startDate)
            ->groupBy('ym', 'type')
            ->get();

        $monthKeys = collect(range(5, 0))->map(fn ($i) => now()->subMonths($i)->format('Y-m'))->values();
        $months = collect(range(5, 0))->map(fn ($i) => now()->subMonths($i)->format('M'))->values()->all();

        $inquiryCounts = $monthKeys->map(function ($ym) use ($inquiryAggregates) {
            return (int) $inquiryAggregates->where('ym', $ym)->sum('count');
        })->all();

        $quoteCounts = $monthKeys->map(function ($ym) use ($inquiryAggregates) {
            return (int) $inquiryAggregates->where('ym', $ym)->where('type', 'quote')->sum('count');
        })->all();

        $serviceDistribution = Service::select('tag')
            ->selectRaw('count(*) as count')
            ->groupBy('tag')
            ->pluck('count', 'tag')
            ->toArray();

        if (empty($serviceDistribution)) {
            $serviceDistribution = [
                'Web Engineering' => 3,
                'Enterprise Arch' => 2,
                'Growth & Funnels' => 1,
                'Cyber Security' => 1,
            ];
        }

        $inquiryStats = Inquiry::selectRaw("
            count(*) as total,
            sum(case when status = 'new' then 1 else 0 end) as new_count,
            sum(case when type = 'quote' then 1 else 0 end) as quote_count,
            sum(case when type = 'contact' then 1 else 0 end) as contact_count
        ")->first();

        return Inertia::render('Admin/Dashboard', [
            'metrics' => [
                'total_inquiries' => (int) ($inquiryStats->total ?? 0),
                'new_inquiries' => (int) ($inquiryStats->new_count ?? 0),
                'quote_requests' => (int) ($inquiryStats->quote_count ?? 0),
                'contact_messages' => (int) ($inquiryStats->contact_count ?? 0),
                'services' => Service::count(),
                'products' => Product::count(),
                'projects' => PortfolioProject::count(),
                'blog_posts' => BlogPost::count(),
                'pricing_plans' => PricingPlan::count(),
                'testimonials' => Testimonial::count(),
                'team_members' => TeamMember::count(),
                'faqs' => Faq::count(),
            ],
            'analytics' => [
                'inquiryTrends' => [
                    'months' => $months,
                    'inquiries' => $inquiryCounts,
                    'quotes' => $quoteCounts,
                ],
                'serviceDistribution' => [
                    'labels' => array_keys($serviceDistribution),
                    'series' => array_values($serviceDistribution),
                ],
            ],
            'recentInquiries' => Inquiry::latest()->take(6)->get(),
        ]);
    }
}
