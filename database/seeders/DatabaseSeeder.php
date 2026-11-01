<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with complete dynamic CMS content.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            ServiceSeeder::class,
            PortfolioProjectSeeder::class,
            TeamMemberSeeder::class,
            TestimonialSeeder::class,
            PricingPlanSeeder::class,
            BlogPostSeeder::class,
            FaqSeeder::class,
        ]);
    }
}
