<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Inquiry extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $fillable = [
        'type',
        'name',
        'email',
        'phone',
        'company',
        'service',
        'selected_features',
        'budget_range',
        'timeline',
        'message',
        'status',
    ];

    protected $casts = [
        'selected_features' => 'array',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
