<?php

namespace App\Models;

use App\Traits\HasUniqueSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class BlogPost extends Model
{
    use HasFactory, HasUniqueSlug, LogsActivity;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'read_time',
        'date',
        'excerpt',
        'image',
        'author',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
