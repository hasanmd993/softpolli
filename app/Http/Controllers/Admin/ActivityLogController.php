<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    /**
     * Display the audit activity log timeline.
     */
    public function index(): Response
    {
        $activities = Activity::with('causer')
            ->latest()
            ->paginate(25)
            ->through(function ($activity) {
                return [
                    'id' => $activity->id,
                    'log_name' => $activity->log_name,
                    'description' => $activity->description,
                    'subject_type' => $activity->subject_type ? class_basename($activity->subject_type) : 'General',
                    'subject_id' => $activity->subject_id,
                    'causer_name' => $activity->causer ? $activity->causer->name : 'System / Guest',
                    'causer_email' => $activity->causer ? $activity->causer->email : null,
                    'properties' => $activity->properties,
                    'event' => $activity->event,
                    'created_at' => $activity->created_at->format('M d, Y H:i:s'),
                    'time_ago' => $activity->created_at->diffForHumans(),
                ];
            });

        return Inertia::render('Admin/ActivityLogs', [
            'activities' => $activities,
        ]);
    }
}
