<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserRoleManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    public function test_guest_cannot_view_users_management(): void
    {
        $response = $this->get('/admin/users');
        $response->assertRedirect('/admin/login');
    }

    public function test_non_admin_user_cannot_access_users_management(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get('/admin/users');
        $response->assertStatus(403);
    }

    public function test_admin_can_view_users_page(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $admin->assignRole('Super Admin');

        $response = $this->actingAs($admin)->get('/admin/users');
        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('Admin/Users'));
    }

    public function test_admin_can_create_new_staff_user_with_role(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $admin->assignRole('Super Admin');

        $response = $this->actingAs($admin)->post('/admin/users', [
            'name' => 'Sabbir Hossain',
            'email' => 'sabbir@softpolli.com',
            'password' => 'secretPassword123!',
            'role' => 'Editor',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('users', [
            'email' => 'sabbir@softpolli.com',
            'name' => 'Sabbir Hossain',
        ]);

        $createdUser = User::where('email', 'sabbir@softpolli.com')->first();
        $this->assertTrue($createdUser->hasRole('Editor'));
    }

    public function test_admin_can_update_user_role(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $admin->assignRole('Super Admin');

        $staff = User::factory()->create(['is_admin' => false]);
        $staff->assignRole('Editor');

        $response = $this->actingAs($admin)->put("/admin/users/{$staff->id}", [
            'name' => 'Updated Staff Name',
            'email' => $staff->email,
            'role' => 'Support Agent',
        ]);

        $response->assertSessionHas('success');
        $staff->refresh();
        $this->assertEquals('Updated Staff Name', $staff->name);
        $this->assertTrue($staff->hasRole('Support Agent'));
        $this->assertFalse($staff->hasRole('Editor'));
    }

    public function test_admin_cannot_delete_their_own_account(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $admin->assignRole('Super Admin');

        $response = $this->actingAs($admin)->delete("/admin/users/{$admin->id}");
        $response->assertSessionHasErrors(['error']);

        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_admin_can_delete_another_staff_account(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $admin->assignRole('Super Admin');

        $staff = User::factory()->create(['is_admin' => false]);
        $staff->assignRole('Support Agent');

        $response = $this->actingAs($admin)->delete("/admin/users/{$staff->id}");
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('users', ['id' => $staff->id]);
    }
}

