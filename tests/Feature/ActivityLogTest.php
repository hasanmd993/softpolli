<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Activitylog\Models\Activity;
use Tests\TestCase;

class ActivityLogTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_view_activity_logs(): void
    {
        $response = $this->get('/admin/activity-logs');
        $response->assertRedirect('/admin/login');
    }

    public function test_admin_can_view_activity_logs_page(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->get('/admin/activity-logs');
        $response->assertStatus(200);
    }

    public function test_creating_a_service_records_an_activity_log(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post('/admin/services', [
            'title' => 'Kubernetes Infrastructure Management',
            'description' => 'Comprehensive multi-region cloud cluster deployment.',
            'tag' => 'DevOps',
            'is_active' => true,
        ]);

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('services', [
            'title' => 'Kubernetes Infrastructure Management',
        ]);

        $latestActivity = Activity::latest()->first();
        $this->assertNotNull($latestActivity);
        $this->assertEquals(Service::class, $latestActivity->subject_type);
    }
}
