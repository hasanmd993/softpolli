<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUniqueSlug
{
    /**
     * Generate a unique slug for the model from a given title/name.
     */
    public static function generateUniqueSlug(string $title, ?int $ignoreId = null, string $slugColumn = 'slug'): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while (static::where($slugColumn, $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = "{$baseSlug}-" . ($counter++);
        }

        return $slug;
    }
}
