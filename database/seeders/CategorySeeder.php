<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Enterprise Architecture',
                'type' => 'service',
                'icon' => 'fa-solid fa-sitemap',
                'sort_order' => 1,
            ],
            [
                'name' => 'Web Engineering',
                'type' => 'service',
                'icon' => 'fa-solid fa-code',
                'sort_order' => 2,
            ],
            [
                'name' => 'Growth & Funnels',
                'type' => 'service',
                'icon' => 'fa-solid fa-chart-line',
                'sort_order' => 3,
            ],
            [
                'name' => 'Security & DevSecOps',
                'type' => 'service',
                'icon' => 'fa-solid fa-shield-halved',
                'sort_order' => 4,
            ],
            [
                'name' => 'iOS & Android',
                'type' => 'service',
                'icon' => 'fa-solid fa-mobile-screen-button',
                'sort_order' => 5,
            ],
            [
                'name' => 'Cloud & DevOps',
                'type' => 'service',
                'icon' => 'fa-solid fa-cloud',
                'sort_order' => 6,
            ],
            [
                'name' => 'Search Optimization',
                'type' => 'service',
                'icon' => 'fa-solid fa-magnifying-glass-chart',
                'sort_order' => 7,
            ],
            [
                'name' => 'UI/UX & Product Design',
                'type' => 'service',
                'icon' => 'fa-solid fa-palette',
                'sort_order' => 8,
            ],
            [
                'name' => 'Custom Software',
                'type' => 'service',
                'icon' => 'fa-solid fa-laptop-code',
                'sort_order' => 9,
            ],
        ];

        foreach ($categories as $cat) {
            $record = Category::firstOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                    'name' => $cat['name'],
                    'type' => $cat['type'],
                    'icon' => $cat['icon'],
                    'sort_order' => $cat['sort_order'],
                    'is_active' => true,
                ]
            );

            // Connect existing services matching tag
            Service::whereNull('category_id')
                ->where('tag', $cat['name'])
                ->update(['category_id' => $record->id]);
        }
    }
}
