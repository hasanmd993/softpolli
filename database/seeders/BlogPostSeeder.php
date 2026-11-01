<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Building Scalable ERP Systems in 2026: Lessons from the Field',
                'slug' => 'building-scalable-erp-systems-2026',
                'category' => 'Software Engineering',
                'read_time' => '5 min read',
                'date' => 'Oct 18, 2026',
                'excerpt' => 'How modular software architecture and decoupled database designs help modern businesses automate supply chains without performance bottlenecks.',
                'image' => '/images/happymeeting.jpg',
                'author' => 'Taukir Ahmed',
            ],
            [
                'title' => 'Why Monolithic SPAs with Inertia.js are Winning Web Development',
                'slug' => 'why-monolithic-spas-inertiajs-are-winning',
                'category' => 'Web Architecture',
                'read_time' => '4 min read',
                'date' => 'Oct 14, 2026',
                'excerpt' => 'Eliminating REST API boilerplate while preserving pure Vue 3 client-side reactivity creates faster software and happier development teams.',
                'image' => '/images/skills-1.jpg',
                'author' => 'Sabbir Ahmed',
            ],
            [
                'title' => 'Modern Retail: The Secret to High-Speed Point of Sale Systems',
                'slug' => 'modern-retail-high-speed-pos',
                'category' => 'Retail Tech',
                'read_time' => '6 min read',
                'date' => 'Sep 29, 2026',
                'excerpt' => 'A technical breakdown of how POS-LTE achieves instant receipt generation and offline sync for high-volume restaurant and retail environments.',
                'image' => '/images/projects/5b.png',
                'author' => 'Azmir Hossain',
            ],
        ];

        foreach ($articles as $art) {
            BlogPost::updateOrCreate(['slug' => $art['slug']], $art);
        }
    }
}
