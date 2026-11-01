<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'What technologies do you use for custom software and web applications?',
                'answer' => 'We engineer high-performance platforms using full-stack Laravel 12, Inertia.js, Vue 3, Tailwind CSS, PostgreSQL, and MariaDB/MySQL, backed by secure cloud infrastructure on AWS, DigitalOcean, and dedicated VPS nodes.',
                'sort_order' => 1,
            ],
            [
                'question' => 'How long does it take to deliver an enterprise website or custom software?',
                'answer' => 'Standard business portals take 2 to 4 weeks. Complex enterprise CRM, ERP, and multi-branch POS platforms are structured in agile 2-week sprints, with initial functional prototypes delivered within the first 14 days.',
                'sort_order' => 2,
            ],
            [
                'question' => 'Will my application be mobile-responsive, secure, and SEO-optimized?',
                'answer' => 'Yes. Every platform is designed mobile-first, follows strict OWASP top-10 security standards, includes automated database backups, clean semantic architecture, and high Google Lighthouse performance scores.',
                'sort_order' => 3,
            ],
            [
                'question' => 'Who owns the intellectual property (IP) and source code upon completion?',
                'answer' => 'You retain 100% full ownership of all proprietary source code, database architectures, and digital assets. Upon final handover, we transfer all private Git repositories, server keys, and deployment pipelines directly to your team.',
                'sort_order' => 4,
            ],
            [
                'question' => 'Can you integrate local and international payment gateways?',
                'answer' => 'Yes! We have native integration expertise with bKash Merchant API, Nagad, Rocket, Upay, and SSLCommerz for Bangladesh, as well as Stripe, PayPal, and Paddle for international multi-currency transactions.',
                'sort_order' => 5,
            ],
            [
                'question' => 'How do you handle data security, backups, and disaster recovery?',
                'answer' => 'We configure automated daily off-site encrypted backups, zero-trust role-based permissions (RBAC), database transaction logs, and automated health checks to ensure continuous 99.9% system availability.',
                'sort_order' => 6,
            ],
            [
                'question' => 'Do you provide continuous maintenance and post-launch support?',
                'answer' => 'Yes! Every project includes a 30 to 90-day post-launch warranty. Afterwards, we offer flexible SLA-backed maintenance packages covering security updates, server monitoring, feature additions, and dedicated priority support.',
                'sort_order' => 7,
            ],
        ];

        foreach ($faqs as $f) {
            Faq::updateOrCreate(['question' => $f['question']], $f);
        }
    }
}
