<?php

namespace Database\Seeders;

use App\Models\PricingPlan;
use Illuminate\Database\Seeder;

class PricingPlanSeeder extends Seeder
{
    public function run(): void
    {
        $pricing = [
            [
                'name' => 'Starter Solution',
                'audience' => 'Ideal for startups and growing businesses establishing their digital footprint.',
                'monthly_price' => 299.00,
                'annual_price' => 249.00,
                'is_popular' => false,
                'features' => [
                    'Custom Responsive Website (Up to 7 Pages)',
                    'Modern Vue 3 + Tailwind Interface',
                    'Contact & Lead Capture Form Integration',
                    'Basic Technical SEO & Speed Optimization',
                    'SSL Certificate & Cloud Hosting Setup',
                    '30 Days Dedicated Post-Launch Support',
                ],
                'sort_order' => 1,
            ],
            [
                'name' => 'Professional Business',
                'audience' => 'For expanding companies needing custom CRM, POS or web applications.',
                'monthly_price' => 699.00,
                'annual_price' => 599.00,
                'is_popular' => true,
                'features' => [
                    'Full Custom Web Application or CRM',
                    'Multi-User Role Management & Permissions',
                    'Payment Gateway Integration (bKash, Nagad, Stripe)',
                    'Automated Email & SMS Alerts',
                    'Advanced Analytics & Reporting Dashboard',
                    'Daily Automated Cloud Backups',
                    '3 Months Dedicated Priority Support',
                ],
                'sort_order' => 2,
            ],
            [
                'name' => 'Enterprise Custom',
                'audience' => 'Tailored ERP and multi-branch systems for large enterprises.',
                'monthly_price' => 1499.00,
                'annual_price' => 1299.00,
                'is_popular' => false,
                'features' => [
                    'End-to-End Scalable ERP / POS Architecture',
                    'Multi-Branch & Warehouse Inventory Sync',
                    'Offline First Data Replication',
                    'Dedicated DevSecOps & High-Availability Servers',
                    'Custom Third-Party API Integrations',
                    'Dedicated Account Manager & SLA Guarantee',
                    '1 Year Extended Maintenance & SLA',
                ],
                'sort_order' => 3,
            ],
        ];

        foreach ($pricing as $plan) {
            PricingPlan::updateOrCreate(['name' => $plan['name']], $plan);
        }
    }
}
