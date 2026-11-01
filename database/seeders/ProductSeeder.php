<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'title' => 'CRM',
                'slug' => 'crm',
                'description' => 'Building Stronger Relationships, One Interaction at a Time.',
                'icon' => 'fa-users-gear',
                'bg' => '#E8E4FF',
                'sort_order' => 1,
            ],
            [
                'title' => 'EDU CRM',
                'slug' => 'edu-crm',
                'description' => 'One Stop Solution for Empowering Education Consultancy Firm.',
                'icon' => 'fa-graduation-cap',
                'bg' => '#D9FFE0',
                'sort_order' => 2,
            ],
            [
                'title' => 'HRM',
                'slug' => 'hrm',
                'description' => 'Unlocking Human Potential, Driving Organizational Success, Saving Time.',
                'icon' => 'fa-id-card-clip',
                'bg' => '#FFF0F1',
                'sort_order' => 3,
            ],
            [
                'title' => 'ERP',
                'slug' => 'erp',
                'description' => 'Optimize business processes, improving efficiency and productivity for clients.',
                'icon' => 'fa-sitemap',
                'bg' => '#DBF5FF',
                'sort_order' => 4,
            ],
            [
                'title' => 'E-commerce',
                'slug' => 'e-commerce',
                'description' => 'Transforming Online Shopping Experiences, Affordable and Convenient.',
                'icon' => 'fa-cart-shopping',
                'bg' => '#FFE7D6',
                'sort_order' => 5,
            ],
            [
                'title' => 'Accounting Software',
                'slug' => 'accounting-software',
                'description' => 'Manage Accounting, Simplifying Finances, Empowering Sustainable Growth.',
                'icon' => 'fa-file-invoice-dollar',
                'bg' => '#DAECFF',
                'sort_order' => 6,
            ],
            [
                'title' => 'Inventory Management (POS)',
                'slug' => 'pos-inventory-management',
                'description' => 'Manage Sales Easy, Effortless Transactions, Elevated Retail Experiences.',
                'icon' => 'fa-cash-register',
                'bg' => '#E1FCFF',
                'sort_order' => 7,
            ],
            [
                'title' => 'Restaurant Management',
                'slug' => 'restaurant-management',
                'description' => 'Manage Your Restaurant Perfectly — Optimizing Kitchen and Guest Services.',
                'icon' => 'fa-utensils',
                'bg' => '#FFDAE8',
                'sort_order' => 8,
            ],
        ];

        foreach ($products as $p) {
            Product::updateOrCreate(['slug' => $p['slug']], $p);
        }
    }
}
