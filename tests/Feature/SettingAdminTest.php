<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_admin_settings(): void
    {
        $response = $this->get('/admin/settings');

        $response->assertStatus(302);
        $response->assertRedirect('/admin/login');
    }

    public function test_non_admin_cannot_access_settings(): void
    {
        $user = User::factory()->nonAdmin()->create();

        $response = $this->actingAs($user)->get('/admin/settings');

        $response->assertStatus(403);
    }

    public function test_admin_can_view_settings_page(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get('/admin/settings');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Admin/Settings')
            ->has('settings')
            ->has('groupedSettings')
        );
    }

    public function test_admin_can_update_settings(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->put('/admin/settings', [
            'settings' => [
                'site_name' => 'SoftPolli Global Ltd',
                'whatsapp_enabled' => true,
                'whatsapp_number' => '8801999999999',
            ],
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $this->assertEquals('SoftPolli Global Ltd', Setting::getValue('site_name'));
        $this->assertEquals('1', Setting::getValue('whatsapp_enabled'));
        $this->assertEquals('8801999999999', Setting::getValue('whatsapp_number'));
    }
}

