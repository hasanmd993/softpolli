<?php

namespace Tests\Feature;

use App\Models\Inquiry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SoftPolliTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_pages_render_successfully(): void
    {
        $routes = ['/', '/about', '/services', '/portfolio', '/pricing', '/blog', '/contact'];

        foreach ($routes as $route) {
            $response = $this->get($route);
            $response->assertStatus(200);
        }
    }

    public function test_contact_form_submission_creates_inquiry(): void
    {
        $payload = [
            'name' => 'Fahim Test',
            'email' => 'fahim@example.com',
            'phone' => '+8801700000000',
            'subject' => 'Custom Software Development',
            'message' => 'We need an automated warehouse management system.',
        ];

        $response = $this->post('/contact', $payload);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('inquiries', [
            'type' => 'contact',
            'name' => 'Fahim Test',
            'email' => 'fahim@example.com',
            'service' => 'Custom Software Development',
        ]);
    }

    public function test_dynamic_quote_submission_creates_quote_inquiry(): void
    {
        $payload = [
            'service' => 'Custom ERP & Operations',
            'selected_features' => ['User Roles & Permissions', 'Multi-Branch Inventory Sync'],
            'budget_range' => '$3,000 - $7,000',
            'timeline' => '1 - 2 Months',
            'name' => 'Sara Client',
            'email' => 'sara@enterprise.com',
            'company' => 'Global Logistics Ltd',
            'message' => 'Looking to replace legacy desktop ERP with web-based solution.',
        ];

        $response = $this->post('/quote', $payload);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('inquiries', [
            'type' => 'quote',
            'name' => 'Sara Client',
            'email' => 'sara@enterprise.com',
            'company' => 'Global Logistics Ltd',
        ]);
    }

    public function test_guest_is_redirected_to_admin_login(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/admin/login');
    }

    public function test_admin_can_login_and_access_dashboard(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@softpolli.test',
            'password' => bcrypt('secret123'),
        ]);

        $response = $this->post('/admin/login', [
            'email' => 'admin@softpolli.test',
            'password' => 'secret123',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticatedAs($admin);
    }

    public function test_admin_can_update_inquiry_status(): void
    {
        $admin = User::factory()->create();
        $inquiry = Inquiry::create([
            'type' => 'contact',
            'name' => 'Lead Client',
            'email' => 'lead@example.com',
            'service' => 'Web App',
            'message' => 'Details',
            'status' => 'new',
        ]);

        $response = $this->actingAs($admin)->patch("/admin/inquiries/{$inquiry->id}/status", [
            'status' => 'contacted',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('inquiries', [
            'id' => $inquiry->id,
            'status' => 'contacted',
        ]);
    }

    public function test_contact_form_validation_rejects_invalid_email(): void
    {
        $response = $this->post('/contact', [
            'name' => 'Fahim Test',
            'email' => 'invalid-email-address',
            'message' => 'Hello',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_contact_form_honeypot_drops_spam_submission(): void
    {
        $response = $this->post('/contact', [
            'name' => 'Bot Spammer',
            'email' => 'bot@spammer.com',
            'message' => 'Spam content',
            '_honeypot' => 'I am a bot',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('inquiries', [
            'email' => 'bot@spammer.com',
        ]);
    }

    public function test_inquiry_soft_deletes_without_permanent_loss(): void
    {
        $admin = User::factory()->create();
        $inquiry = Inquiry::create([
            'type' => 'contact',
            'name' => 'Important Lead',
            'email' => 'important@lead.com',
            'service' => 'ERP',
            'message' => 'Critical business request',
            'status' => 'new',
        ]);

        $response = $this->actingAs($admin)->delete("/admin/inquiries/{$inquiry->id}");
        $response->assertSessionHas('success');

        // Assert soft deleted
        $this->assertSoftDeleted('inquiries', ['id' => $inquiry->id]);
        $this->assertDatabaseHas('inquiries', ['id' => $inquiry->id]);
    }
}
