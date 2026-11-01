<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Tanvir Rahman',
                'designation' => 'Managing Director',
                'company' => 'Trust Winner Restaurant',
                'category' => 'Hotel & Restaurant Management',
                'quote' => 'SoftPolli has been an invaluable partner in our digital transformation journey. Their expertise in web and POS solutions, coupled with their dedication to quality, helped us scale our branches seamlessly.',
                'src' => '/images/t1.jpg',
                'sort_order' => 1,
            ],
            [
                'name' => 'Sajal Ahmed',
                'designation' => 'Chief Executive Officer',
                'company' => 'IB Educational Institute',
                'category' => 'Education & Learning Management',
                'quote' => 'The team at SoftPolli exceeded our expectations in every way. Their custom EDU CRM automated our entire student admission pipeline and saved hundreds of administrative hours.',
                'src' => '/images/t2.png',
                'sort_order' => 2,
            ],
        ];

        foreach ($testimonials as $t) {
            Testimonial::updateOrCreate(['name' => $t['name']], $t);
        }
    }
}
