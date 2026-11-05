<?php

namespace Tests\Feature;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_retrieve_default_setting_value(): void
    {
        $this->assertEquals('Fallback Value', Setting::getValue('non_existent_key', 'Fallback Value'));
    }

    public function test_can_store_and_retrieve_cached_settings(): void
    {
        Setting::setMany([
            'site_name' => 'SoftPolli Tech',
            'whatsapp_enabled' => true,
        ]);

        $this->assertEquals('SoftPolli Tech', Setting::getValue('site_name'));
        $this->assertEquals('1', Setting::getValue('whatsapp_enabled'));

        $all = Setting::getAllSettings();
        $this->assertArrayHasKey('site_name', $all);
        $this->assertEquals('SoftPolli Tech', $all['site_name']);
    }
}

