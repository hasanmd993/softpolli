<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MediaUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_upload_media(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('test.jpg', 600, 600);

        $response = $this->postJson('/admin/media/upload', [
            'file' => $file,
        ]);

        $response->assertStatus(401);
    }

    public function test_admin_can_upload_image_and_receive_webp_url(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create();

        $file = UploadedFile::fake()->image('banner.png', 1200, 800);

        $response = $this->actingAs($admin)->postJson('/admin/media/upload', [
            'file' => $file,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['url']);

        $url = $response->json('url');
        $this->assertStringStartsWith('/storage/uploads/', $url);
        $this->assertStringEndsWith('.webp', $url);

        $storagePath = str_replace('/storage/', '', $url);
        Storage::disk('public')->assertExists($storagePath);
    }

    public function test_upload_rejects_non_image_files(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create();

        $file = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');

        $response = $this->actingAs($admin)->postJson('/admin/media/upload', [
            'file' => $file,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['file']);
    }
}
