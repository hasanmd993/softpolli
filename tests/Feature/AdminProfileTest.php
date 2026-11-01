<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_profile()
    {
        $response = $this->get('/admin/profile');
        $response->assertRedirect('/admin/login');
    }

    public function test_admin_can_view_profile_page()
    {
        $admin = User::factory()->create([
            'email' => 'admin@softpolli.com',
        ]);

        $response = $this->actingAs($admin)->get('/admin/profile');
        $response->assertStatus(200);
    }

    public function test_admin_can_update_password_with_correct_current_password()
    {
        $admin = User::factory()->create([
            'email' => 'admin@softpolli.com',
            'password' => Hash::make('old-password-123'),
        ]);

        $response = $this->actingAs($admin)->put('/admin/profile/password', [
            'current_password' => 'old-password-123',
            'password' => 'new-secret-password-456',
            'password_confirmation' => 'new-secret-password-456',
        ]);

        $response->assertSessionHas('success');
        $this->assertTrue(Hash::check('new-secret-password-456', $admin->fresh()->password));
    }

    public function test_admin_cannot_update_password_with_wrong_current_password()
    {
        $admin = User::factory()->create([
            'email' => 'admin@softpolli.com',
            'password' => Hash::make('correct-password'),
        ]);

        $response = $this->actingAs($admin)->put('/admin/profile/password', [
            'current_password' => 'wrong-password',
            'password' => 'brand-new-password',
            'password_confirmation' => 'brand-new-password',
        ]);

        $response->assertSessionHasErrors('current_password');
        $this->assertFalse(Hash::check('brand-new-password', $admin->fresh()->password));
    }
}
