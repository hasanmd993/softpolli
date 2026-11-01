<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Faq;
use App\Models\PortfolioProject;
use App\Models\PricingPlan;
use App\Models\Product;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminModulesTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    public function test_all_dynamic_admin_routes_require_authentication(): void
    {
        $routes = [
            '/admin/services',
            '/admin/products',
            '/admin/portfolio',
            '/admin/blog-posts',
            '/admin/pricing-plans',
            '/admin/testimonials',
            '/admin/team-members',
            '/admin/faqs',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);
            $response->assertRedirect('/admin/login');
        }
    }

    public function test_admin_can_access_all_dynamic_module_pages(): void
    {
        $routes = [
            '/admin/services',
            '/admin/products',
            '/admin/portfolio',
            '/admin/blog-posts',
            '/admin/pricing-plans',
            '/admin/testimonials',
            '/admin/team-members',
            '/admin/faqs',
        ];

        foreach ($routes as $route) {
            $response = $this->actingAs($this->admin)->get($route);
            $response->assertStatus(200);
        }
    }

    public function test_admin_can_crud_services(): void
    {
        // 1. Create
        $response = $this->actingAs($this->admin)->post('/admin/services', [
            'title' => 'Cloud Migration Service',
            'description' => 'Migrate on-prem infrastructure to secure AWS and Google Cloud environments.',
            'tag' => 'Infrastructure',
            'is_active' => true,
        ]);
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('services', ['title' => 'Cloud Migration Service']);

        $service = Service::where('title', 'Cloud Migration Service')->first();

        // 2. Update
        $updateResponse = $this->actingAs($this->admin)->put("/admin/services/{$service->id}", [
            'title' => 'Cloud & DevOps Migration',
            'description' => 'Updated description for cloud devops.',
            'tag' => 'DevOps',
            'is_active' => true,
        ]);
        $updateResponse->assertSessionHas('success');
        $this->assertDatabaseHas('services', ['title' => 'Cloud & DevOps Migration']);

        // 3. Toggle
        $toggleResponse = $this->actingAs($this->admin)->patch("/admin/services/{$service->id}/toggle");
        $toggleResponse->assertSessionHas('success');
        $this->assertDatabaseHas('services', ['id' => $service->id, 'is_active' => false]);

        // 4. Delete
        $deleteResponse = $this->actingAs($this->admin)->delete("/admin/services/{$service->id}");
        $deleteResponse->assertSessionHas('success');
        $this->assertDatabaseMissing('services', ['id' => $service->id]);
    }

    public function test_admin_can_create_category_and_link_to_service(): void
    {
        $catResponse = $this->actingAs($this->admin)->post('/admin/categories', [
            'name' => 'NextGen Cloud Architecture',
            'type' => 'service',
        ]);
        $catResponse->assertSessionHas('success');
        $this->assertDatabaseHas('categories', ['name' => 'NextGen Cloud Architecture']);

        $category = Category::where('name', 'NextGen Cloud Architecture')->first();

        $serviceResponse = $this->actingAs($this->admin)->post('/admin/services', [
            'title' => 'Kubernetes Multi-Region Clusters',
            'description' => 'Enterprise Kubernetes cluster deployment with high availability.',
            'category_id' => $category->id,
            'is_active' => true,
        ]);
        $serviceResponse->assertSessionHas('success');

        $this->assertDatabaseHas('services', [
            'title' => 'Kubernetes Multi-Region Clusters',
            'category_id' => $category->id,
            'tag' => 'NextGen Cloud Architecture',
        ]);
    }

    public function test_admin_can_crud_products(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/products', [
            'title' => 'RetailPOS Cloud',
            'description' => 'Smart multi-outlet POS platform.',
            'icon' => 'fa-cash-register',
            'bg' => '#E8E4FF',
            'is_active' => true,
        ]);
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('products', ['title' => 'RetailPOS Cloud']);

        $product = Product::where('title', 'RetailPOS Cloud')->first();

        $this->actingAs($this->admin)->patch("/admin/products/{$product->id}/toggle");
        $this->assertDatabaseHas('products', ['id' => $product->id, 'is_active' => false]);

        $this->actingAs($this->admin)->delete("/admin/products/{$product->id}");
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_admin_can_crud_portfolio_projects(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/portfolio', [
            'title' => 'Apex Logistics Platform',
            'category' => 'Enterprise Web App',
            'tagline' => 'Automated Freight Tracking',
            'description' => 'High throughput tracking application.',
            'image' => '/images/work-1.jpg',
            'metrics' => '99.99% Uptime',
            'is_featured' => true,
        ]);
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('portfolio_projects', ['title' => 'Apex Logistics Platform']);

        $project = PortfolioProject::where('title', 'Apex Logistics Platform')->first();

        $this->actingAs($this->admin)->patch("/admin/portfolio/{$project->id}/toggle");
        $this->assertDatabaseHas('portfolio_projects', ['id' => $project->id, 'is_featured' => false]);

        $this->actingAs($this->admin)->delete("/admin/portfolio/{$project->id}");
        $this->assertDatabaseMissing('portfolio_projects', ['id' => $project->id]);
    }

    public function test_admin_can_crud_blog_posts(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/blog-posts', [
            'title' => 'Scaling Laravel with Horizon',
            'category' => 'Engineering',
            'excerpt' => 'How we optimize queue workers under load.',
            'image' => '/images/blog-1.jpg',
            'author' => 'Lead Dev',
            'is_published' => true,
        ]);
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('blog_posts', ['title' => 'Scaling Laravel with Horizon']);

        $post = BlogPost::where('title', 'Scaling Laravel with Horizon')->first();

        $this->actingAs($this->admin)->patch("/admin/blog-posts/{$post->id}/toggle");
        $this->assertDatabaseHas('blog_posts', ['id' => $post->id, 'is_published' => false]);

        $this->actingAs($this->admin)->delete("/admin/blog-posts/{$post->id}");
        $this->assertDatabaseMissing('blog_posts', ['id' => $post->id]);
    }

    public function test_admin_can_crud_pricing_plans(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/pricing-plans', [
            'name' => 'Custom Dedicated Team',
            'audience' => 'Growing enterprises requiring dedicated squads',
            'monthly_price' => 4500,
            'annual_price' => 45000,
            'features' => ['Dedicated Tech Lead', 'Daily Standups', 'CI/CD Pipelines'],
            'is_popular' => true,
        ]);
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('pricing_plans', ['name' => 'Custom Dedicated Team']);

        $plan = PricingPlan::where('name', 'Custom Dedicated Team')->first();

        $this->actingAs($this->admin)->patch("/admin/pricing-plans/{$plan->id}/toggle");
        $this->assertDatabaseHas('pricing_plans', ['id' => $plan->id, 'is_popular' => false]);

        $this->actingAs($this->admin)->delete("/admin/pricing-plans/{$plan->id}");
        $this->assertDatabaseMissing('pricing_plans', ['id' => $plan->id]);
    }

    public function test_admin_can_crud_testimonials(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/testimonials', [
            'name' => 'Michael Chen',
            'designation' => 'CTO',
            'company' => 'Aether FinTech',
            'category' => 'Banking API Integration',
            'quote' => 'SoftPolli executed our compliance security audit with perfection.',
            'src' => '/images/testimonial-1.jpg',
        ]);
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('testimonials', ['name' => 'Michael Chen']);

        $testimonial = Testimonial::where('name', 'Michael Chen')->first();

        $this->actingAs($this->admin)->delete("/admin/testimonials/{$testimonial->id}");
        $this->assertDatabaseMissing('testimonials', ['id' => $testimonial->id]);
    }

    public function test_admin_can_crud_team_members(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/team-members', [
            'name' => 'Amina Rahman',
            'role' => 'Senior DevOps Architect',
            'image' => '/images/team-1.jpg',
            'social' => ['linkedin' => 'https://linkedin.com'],
        ]);
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('team_members', ['name' => 'Amina Rahman']);

        $member = TeamMember::where('name', 'Amina Rahman')->first();

        $this->actingAs($this->admin)->delete("/admin/team-members/{$member->id}");
        $this->assertDatabaseMissing('team_members', ['id' => $member->id]);
    }

    public function test_admin_can_crud_faqs(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/faqs', [
            'question' => 'What is your typical project warranty?',
            'answer' => 'We provide 90 days of free bug-fixing warranty after deployment.',
            'category' => 'Support',
        ]);
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('faqs', ['question' => 'What is your typical project warranty?']);

        $faq = Faq::where('question', 'What is your typical project warranty?')->first();

        $this->actingAs($this->admin)->delete("/admin/faqs/{$faq->id}");
        $this->assertDatabaseMissing('faqs', ['id' => $faq->id]);
    }
}
