<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Setting extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'key',
        'value',
        'group',
        'type',
        'label',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Cache key for all site settings.
     */
    public const CACHE_KEY = 'softpolli_site_settings';

    /**
     * Retrieve all settings as key => value dictionary (cached).
     */
    public static function getAllSettings(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            return static::pluck('value', 'key')->toArray();
        });
    }

    /**
     * Get a specific setting value by key with optional fallback.
     */
    public static function getValue(string $key, mixed $default = null): mixed
    {
        $settings = static::getAllSettings();
        return $settings[$key] ?? $default;
    }

    /**
     * Mass set key-values and clear cache.
     */
    public static function setMany(array $keyValues): void
    {
        foreach ($keyValues as $key => $value) {
            static::updateOrCreate(
                ['key' => $key],
                ['value' => is_bool($value) ? ($value ? '1' : '0') : (string) $value]
            );
        }

        static::flushCache();
    }

    /**
     * Invalidate settings cache.
     */
    public static function flushCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    protected static function booted(): void
    {
        static::saved(function () {
            static::flushCache();
        });

        static::deleted(function () {
            static::flushCache();
        });
    }
}

