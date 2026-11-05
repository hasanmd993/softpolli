<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\CaptchaService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class AdminAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_admin_dashboard_to_login(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertStatus(302);
        $response->assertRedirect('/admin/login');
    }

    public function test_non_admin_user_is_forbidden_from_accessing_admin_dashboard(): void
    {
        $user = User::factory()->nonAdmin()->create();

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertStatus(403);
    }

    public function test_admin_user_can_access_admin_dashboard(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
    }

    public function test_login_page_renders_with_captcha_challenge(): void
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('Admin/Login')->has('captcha.question'));
    }

    public function test_can_refresh_captcha_endpoint(): void
    {
        $response = $this->get('/admin/captcha/refresh');

        $response->assertStatus(200);
        $response->assertJsonStructure(['question', 'token']);
    }

    public function test_login_fails_with_invalid_captcha_answer(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@softpolli.com',
            'password' => bcrypt('password123'),
            'is_admin' => true,
        ]);

        $response = $this->post('/admin/login', [
            'email' => 'admin@softpolli.com',
            'password' => 'password123',
            'captcha_answer' => '999999',
            'captcha_token' => 'invalid_token',
        ]);

        $response->assertSessionHasErrors(['captcha_answer']);
        $this->assertGuest();
    }

    public function test_login_succeeds_with_valid_captcha_answer(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@softpolli.com',
            'password' => bcrypt('password123'),
            'is_admin' => true,
        ]);

        $captcha = CaptchaService::generate();
        $correctAnswer = Session::get('login_captcha_answer');

        $response = $this->post('/admin/login', [
            'email' => 'admin@softpolli.com',
            'password' => 'password123',
            'captcha_answer' => $correctAnswer,
            'captcha_token' => $captcha['token'],
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticatedAs($admin);
    }
}
