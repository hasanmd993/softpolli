<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogPostViewTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_published_blog_post_by_slug()
    {
        $post = BlogPost::create([
            'title' => 'Building Scalable Web Applications',
            'slug' => 'building-scalable-web-applications',
            'category' => 'Engineering',
            'read_time' => '5 min read',
            'date' => 'Oct 30, 2026',
            'excerpt' => 'A comprehensive guide to modern architecture.',
            'image' => '/images/blog1.webp',
            'author' => 'Sarah Connor',
            'is_published' => true,
        ]);

        $response = $this->get('/blog/building-scalable-web-applications');
        $response->assertStatus(200);
        $response->assertSee('Building Scalable Web Applications');
        $response->assertSee('Sarah Connor');
    }

    public function test_viewing_unpublished_blog_post_returns_404()
    {
        $post = BlogPost::create([
            'title' => 'Draft Article',
            'slug' => 'draft-article',
            'category' => 'Engineering',
            'read_time' => '3 min read',
            'date' => 'Oct 30, 2026',
            'excerpt' => 'Not yet ready for the public.',
            'image' => '/images/blog2.webp',
            'author' => 'John Doe',
            'is_published' => false,
        ]);

        $response = $this->get('/blog/draft-article');
        $response->assertStatus(404);
    }

    public function test_viewing_nonexistent_slug_returns_404()
    {
        $response = $this->get('/blog/non-existent-article-slug');
        $response->assertStatus(404);
    }
}
