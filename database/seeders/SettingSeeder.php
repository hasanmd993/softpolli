<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultSettings = [
            // General Group
            [
                'key' => 'site_name',
                'value' => 'SoftPolli',
                'group' => 'general',
                'type' => 'text',
                'label' => 'Site Name',
            ],
            [
                'key' => 'site_tagline',
                'value' => 'Smart Software Solutions For Modern Businesses',
                'group' => 'general',
                'type' => 'text',
                'label' => 'Site Tagline',
            ],
            [
                'key' => 'contact_email',
                'value' => 'info@softpolli.com',
                'group' => 'general',
                'type' => 'text',
                'label' => 'Primary Contact Email',
            ],
            [
                'key' => 'support_email',
                'value' => 'support@softpolli.com',
                'group' => 'general',
                'type' => 'text',
                'label' => 'Support / Inquiries Email',
            ],
            [
                'key' => 'contact_phone',
                'value' => '+880 1711-000000',
                'group' => 'general',
                'type' => 'text',
                'label' => 'Primary Contact Phone',
            ],
            [
                'key' => 'contact_phone_secondary',
                'value' => '+880 1800-000000',
                'group' => 'general',
                'type' => 'text',
                'label' => 'Secondary Hotline / Phone',
            ],
            [
                'key' => 'office_address',
                'value' => '2B/4 Ring Road, Shyamoli, Dhaka - 1207',
                'group' => 'general',
                'type' => 'textarea',
                'label' => 'Office Address',
            ],
            [
                'key' => 'business_hours',
                'value' => 'Sat to Thursday: 8:00 am - 7:00 pm',
                'group' => 'general',
                'type' => 'text',
                'label' => 'Business Working Hours',
            ],
            [
                'key' => 'google_maps_url',
                'value' => 'https://maps.google.com/?q=2B/4+Ring+Road+Shyamoli+Dhaka',
                'group' => 'general',
                'type' => 'text',
                'label' => 'Google Maps Directions Link',
            ],

            // WhatsApp Group
            [
                'key' => 'whatsapp_enabled',
                'value' => '1',
                'group' => 'whatsapp',
                'type' => 'boolean',
                'label' => 'Enable WhatsApp Chat Widget',
            ],
            [
                'key' => 'whatsapp_number',
                'value' => '8801700000000',
                'group' => 'whatsapp',
                'type' => 'text',
                'label' => 'WhatsApp Number (with country code)',
            ],
            [
                'key' => 'whatsapp_agent_name',
                'value' => 'SoftPolli Solutions Team',
                'group' => 'whatsapp',
                'type' => 'text',
                'label' => 'WhatsApp Agent / Team Name',
            ],
            [
                'key' => 'whatsapp_welcome_message',
                'value' => 'Hello! How can we assist with your software project today?',
                'group' => 'whatsapp',
                'type' => 'textarea',
                'label' => 'WhatsApp Welcome Message',
            ],
            [
                'key' => 'whatsapp_default_message',
                'value' => 'Hello SoftPolli team, I am interested in discussing a software project.',
                'group' => 'whatsapp',
                'type' => 'textarea',
                'label' => 'Default WhatsApp Chat Pre-fill Text',
            ],

            // Social Group
            [
                'key' => 'social_facebook',
                'value' => 'https://facebook.com/softpolli',
                'group' => 'social',
                'type' => 'text',
                'label' => 'Facebook Page URL',
            ],
            [
                'key' => 'social_linkedin',
                'value' => 'https://linkedin.com/company/softpolli',
                'group' => 'social',
                'type' => 'text',
                'label' => 'LinkedIn Company URL',
            ],
            [
                'key' => 'social_twitter',
                'value' => 'https://twitter.com/softpolli',
                'group' => 'social',
                'type' => 'text',
                'label' => 'X / Twitter Profile URL',
            ],
            [
                'key' => 'social_github',
                'value' => 'https://github.com/softpolli',
                'group' => 'social',
                'type' => 'text',
                'label' => 'GitHub Profile URL',
            ],
        ];

        foreach ($defaultSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        Setting::flushCache();
    }
}

