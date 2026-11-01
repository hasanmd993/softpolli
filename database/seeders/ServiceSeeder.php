<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'Software Solutions & Consultancy',
                'slug' => 'software-solutions-consultancy',
                'description' => 'Custom enterprise software designed to automate core business workflows, integrate databases, and scale operations.',
                'image' => '/images/service-2.png',
                'tag' => 'Enterprise Architecture',
                'sort_order' => 1,
            ],
            [
                'title' => 'Website & Portfolio',
                'slug' => 'website-portfolio',
                'description' => 'High-conversion corporate websites and interactive digital portals built for performance, mobile responsiveness, and SEO.',
                'image' => '/images/service/website.jpg',
                'tag' => 'Web Engineering',
                'sort_order' => 2,
            ],
            [
                'title' => 'Digital Marketing & Consultancy',
                'slug' => 'digital-marketing-consultancy',
                'description' => 'Data-driven growth strategies, programmatic ad campaigns, and targeted customer acquisition funnels.',
                'image' => '/images/service/Digi.jpg',
                'tag' => 'Growth & Funnels',
                'sort_order' => 3,
            ],
            [
                'title' => 'Cyber Security & Consulting',
                'slug' => 'cyber-security-consulting',
                'description' => 'Penetration testing, cloud infrastructure hardening, vulnerability audits, and proactive disaster recovery systems.',
                'image' => '/images/service/cyber.jpg',
                'tag' => 'Security & DevSecOps',
                'sort_order' => 4,
            ],
            [
                'title' => 'Mobile App Development',
                'slug' => 'mobile-app-development',
                'description' => 'Native and cross-platform iOS & Android mobile apps engineered with offline sync and intuitive UX.',
                'image' => '/images/service/mobile.jpg',
                'tag' => 'iOS & Android',
                'sort_order' => 5,
            ],
            [
                'title' => 'Domain & Web Hosting',
                'slug' => 'domain-web-hosting',
                'description' => 'High-availability managed cloud hosting, automated SSL encryption, global CDN, and zero-downtime deployments.',
                'image' => '/images/service/web-hosting.jpg',
                'tag' => 'Cloud & DevOps',
                'sort_order' => 6,
            ],
            [
                'title' => 'SEO Services',
                'slug' => 'seo-services',
                'description' => 'Technical on-page SEO, speed optimization, structured schema markup, and authoritative ranking strategies.',
                'image' => '/images/service/seo.jpg',
                'tag' => 'Search Optimization',
                'sort_order' => 7,
            ],
        ];

        foreach ($services as $s) {
            Service::updateOrCreate(['slug' => $s['slug']], $s);
        }
    }
}
