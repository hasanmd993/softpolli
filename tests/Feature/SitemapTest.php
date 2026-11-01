<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SitemapTest extends TestCase
{
    use RefreshDatabase;

    public function test_sitemap_returns_valid_xml_with_public_and_dynamic_urls()
    {
        $post = BlogPost::create([
            'title' => 'Sitemap Guide for High Performance',
            'slug' => 'sitemap-guide-for-high-performance',
            'category' => 'SEO',
            'read_time' => '4 min read',
            'date' => 'Oct 30, 2026',
            'excerpt' => 'How XML sitemaps boost search indexation.',
            'image' => '/images/blog1.webp',
            'author' => 'Engineering Lead',
            'is_published' => true,
        ]);

        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $this->assertStringContainsString('xml', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('<urlset', $response->getContent());
        $this->assertStringContainsString('/about', $response->getContent());
        $this->assertStringContainsString('/services', $response->getContent());
        $this->assertStringContainsString('/portfolio', $response->getContent());
        $this->assertStringContainsString('/blog/sitemap-guide-for-high-performance', $response->getContent());
    }
}
