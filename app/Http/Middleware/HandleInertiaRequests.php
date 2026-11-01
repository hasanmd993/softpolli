<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return config('app.env') === 'production' ? parent::version($request) : null;
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user() ? [
                    'id' => $request->user()->id,
                    'name' => $request->user()->name,
                    'email' => $request->user()->email,
                ] : null,
            ],
            'csrf_token' => fn () => csrf_token(),
            'newInquiriesCount' => fn () => \Illuminate\Support\Facades\Schema::hasTable('inquiries') ? \App\Models\Inquiry::where('status', 'new')->count() : 0,
            'recentNotifications' => fn () => $request->user() && \Illuminate\Support\Facades\Schema::hasTable('inquiries')
                ? \App\Models\Inquiry::latest()->take(5)->get()->map(fn ($inq) => [
                    'id' => $inq->id,
                    'type' => $inq->type,
                    'name' => $inq->name,
                    'service' => $inq->service ?: 'General',
                    'status' => $inq->status,
                    'time' => $inq->created_at?->diffForHumans() ?? 'Just now',
                ])
                : [],
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
        ];
    }
}
