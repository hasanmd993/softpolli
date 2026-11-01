<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'audience',
        'monthly_price',
        'annual_price',
        'is_popular',
        'features',
        'sort_order',
    ];

    protected $casts = [
        'is_popular' => 'boolean',
        'features' => 'array',
        'monthly_price' => 'float',
        'annual_price' => 'float',
    ];
}
