<?php

namespace Database\Seeders;

use App\Models\PortfolioProject;
use Illuminate\Database\Seeder;

class PortfolioProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'number' => '01',
                'title' => 'POS-LTE',
                'slug' => 'pos-lte',
                'category' => 'Retail & Restaurant Tech',
                'tagline' => 'Modern Point of Sale and Receipt Management System',
                'description' => 'A streamlined interface for managing food items, creating orders, tracking branch sales, and printing customer receipts instantly with offline cache support.',
                'image' => '/images/projects/5b.png',
                'live_url' => 'https://pos-lte.vercel.app/',
                'metrics' => '3x Faster Order Processing',
                'sort_order' => 1,
            ],
            [
                'number' => '02',
                'title' => 'TicketBari',
                'slug' => 'ticketbari',
                'category' => 'Transport & Ticketing',
                'tagline' => 'Online Bus, Train, Flight & Launch Ticket Booking Platform',
                'description' => 'Comprehensive booking platform for travelers across Bangladesh with live route searching, seat selection, and automated digital ticket issuance.',
                'image' => '/images/projects/3.png',
                'live_url' => 'https://ticketbari-client-side.netlify.app/',
                'metrics' => 'Seamless Multi-Route Booking',
                'sort_order' => 2,
            ],
            [
                'number' => '03',
                'title' => 'StyleDecor',
                'slug' => 'styledecor',
                'category' => 'Smart Home & Events',
                'tagline' => 'Event Decoration & Smart Home Service Booking Platform',
                'description' => 'Interactive service catalog for event styling and interior renovations with geographical service area locator and vendor booking calendar.',
                'image' => '/images/projects/1.png',
                'live_url' => 'https://style-decor-client-side.netlify.app/',
                'metrics' => 'Interactive Area Mapping',
                'sort_order' => 3,
            ],
            [
                'number' => '04',
                'title' => 'CMS Company Portal',
                'slug' => 'cms-company-portal',
                'category' => 'Publishing & Media',
                'tagline' => 'Content Management System & Enterprise Web Solutions',
                'description' => 'Modern headless CMS featuring dynamic block editors, role-based publishing workflows, and integrated media optimization.',
                'image' => '/images/projects/2.png',
                'live_url' => '#',
                'metrics' => 'Modular Content Blocks',
                'sort_order' => 4,
            ],
        ];

        foreach ($projects as $proj) {
            PortfolioProject::updateOrCreate(['slug' => $proj['slug']], $proj);
        }
    }
}
