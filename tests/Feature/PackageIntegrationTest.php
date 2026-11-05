<?php

namespace Tests\Feature;

use App\Models\Inquiry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PackageIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_secure_headers_are_applied_to_web_responses()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
    }

    public function test_admin_can_export_inquiries_to_excel()
    {
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        Inquiry::create([
            'type' => 'contact',
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'message' => 'Test message',
            'status' => 'new',
        ]);

        $response = $this->actingAs($admin)->get('/admin/inquiries/export');

        $response->assertStatus(200);
        $this->assertStringContainsString('softpolli-inquiries-', $response->headers->get('content-disposition'));
    }

    public function test_admin_can_download_inquiry_pdf()
    {
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        $inquiry = Inquiry::create([
            'type' => 'quote',
            'name' => 'Jane Tech',
            'email' => 'jane@example.com',
            'company' => 'Tech Corp',
            'service' => 'ERP Development',
            'budget_range' => '$10,000 - $25,000',
            'message' => 'Need full ERP solution.',
            'status' => 'reviewed',
        ]);

        $response = $this->actingAs($admin)->get("/admin/inquiries/{$inquiry->id}/pdf");

        $response->assertStatus(200);
        $this->assertEquals('application/pdf', $response->headers->get('content-type'));
        $this->assertStringContainsString("softpolli-inquiry-{$inquiry->id}.pdf", $response->headers->get('content-disposition'));
    }

    public function test_admin_can_export_staff_users_to_excel()
    {
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        $response = $this->actingAs($admin)->get('/admin/users/export');

        $response->assertStatus(200);
        $this->assertStringContainsString('softpolli-staff-', $response->headers->get('content-disposition'));
    }
}

