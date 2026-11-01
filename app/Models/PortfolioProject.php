<?php

namespace App\Models;

use App\Traits\HasUniqueSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class PortfolioProject extends Model
{
    use HasFactory, HasUniqueSlug, LogsActivity;

    protected $fillable = [
        'number',
        'title',
        'slug',
        'category',
        'tagline',
        'description',
        'image',
        'live_url',
        'metrics',
        'sort_order',
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
