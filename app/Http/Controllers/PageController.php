<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Faq;
use App\Models\PortfolioProject;
use App\Models\PricingPlan;
use App\Models\Product;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    /**
     * Render the Home landing page with dynamic database models.
     */
    public function home(): Response
    {
        return Inertia::render('Home', [
            'products' => Product::where('is_active', true)->orderBy('sort_order')->get(),
            'services' => Service::where('is_active', true)->orderBy('sort_order')->get(),
            'projects' => PortfolioProject::where('is_featured', true)->orderBy('sort_order')->get(),
            'teamMembers' => TeamMember::orderBy('sort_order')->get(),
            'testimonials' => Testimonial::orderBy('sort_order')->get(),
            'faqs' => Faq::orderBy('sort_order')->get()->map(fn ($faq) => [
                'q' => $faq->question,
                'a' => $faq->answer,
            ]),
        ]);
    }

    /**
     * Render the About Us page with dynamic database models.
     */
    public function about(): Response
    {
        return Inertia::render('About', [
            'teamMembers' => TeamMember::orderBy('sort_order')->get(),
        ]);
    }

    /**
     * Render the Services catalog page with dynamic database models.
     */
    public function services(): Response
    {
        return Inertia::render('Services', [
            'services' => Service::where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }

    /**
     * Render the Portfolio showcase page with dynamic database models.
     */
    public function portfolio(): Response
    {
        return Inertia::render('Portfolio', [
            'projects' => PortfolioProject::orderBy('sort_order')->get(),
        ]);
    }

    /**
     * Render a single portfolio project case study page.
     */
    public function portfolioProject(string $slug): Response
    {
        $project = PortfolioProject::where('slug', $slug)->firstOrFail();

        $relatedProjects = PortfolioProject::where('id', '!=', $project->id)
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        return Inertia::render('PortfolioProject', [
            'project' => $project,
            'relatedProjects' => $relatedProjects,
        ]);
    }

    /**
     * Render the Pricing & Packages page with dynamic database models.
     */
    public function pricing(): Response
    {
        return Inertia::render('Pricing', [
            'plans' => PricingPlan::orderBy('sort_order')->get(),
            'faqs' => Faq::orderBy('sort_order')->get()->map(fn ($faq) => [
                'q' => $faq->question,
                'a' => $faq->answer,
            ]),
        ]);
    }

    /**
     * Render the Tech Blog & News page with dynamic database models.
     */
    public function blog(): Response
    {
        return Inertia::render('Blog', [
            'articles' => BlogPost::where('is_published', true)->orderByDesc('id')->get(),
        ]);
    }

    /**
     * Render a single blog post reader page.
     */
    public function blogPost(string $slug): Response
    {
        $post = BlogPost::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $relatedPosts = BlogPost::where('is_published', true)
            ->where('id', '!=', $post->id)
            ->orderByDesc('id')
            ->limit(3)
            ->get();

        return Inertia::render('BlogPost', [
            'post' => $post,
            'relatedPosts' => $relatedPosts,
        ]);
    }

    /**
     * Render the Contact & Dynamic Quote Estimator page.
     */
    public function contact(): Response
    {
        return Inertia::render('Contact', [
            'services' => Service::where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }
}
