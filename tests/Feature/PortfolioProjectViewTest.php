<?php

namespace Tests\Feature;

use App\Models\PortfolioProject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioProjectViewTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_single_portfolio_project_by_slug(): void
    {
        $project = PortfolioProject::create([
            'number' => '01',
            'title' => 'Cloud ERP Architecture',
            'slug' => 'cloud-erp-architecture',
            'category' => 'Enterprise Web',
            'tagline' => 'Scalable ERP system for retail distributors',
            'description' => '<p>Modern ERP built with Laravel and Vue.</p>',
            'image' => '/images/portfolio/erp.png',
            'live_url' => 'https://example.com',
            'metrics' => '99.99% Uptime',
            'sort_order' => 1,
            'is_featured' => true,
        ]);

        $response = $this->get('/portfolio/cloud-erp-architecture');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('PortfolioProject')
            ->has('project')
            ->where('project.title', 'Cloud ERP Architecture')
            ->where('project.slug', 'cloud-erp-architecture')
        );
    }

    public function test_returns_404_for_non_existent_portfolio_slug(): void
    {
        $response = $this->get('/portfolio/non-existent-case-study');

        $response->assertStatus(404);
    }
}

