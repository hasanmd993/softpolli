<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BlogPostAdminController;
use App\Http\Controllers\Admin\CategoryAdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqAdminController;
use App\Http\Controllers\Admin\InquiryAdminController;
use App\Http\Controllers\Admin\MediaUploadController;
use App\Http\Controllers\Admin\PortfolioAdminController;
use App\Http\Controllers\Admin\PricingPlanAdminController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\ServiceAdminController;
use App\Http\Controllers\Admin\SettingAdminController;
use App\Http\Controllers\Admin\TeamMemberAdminController;
use App\Http\Controllers\Admin\TestimonialAdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// ==========================================
// Public Marketing Pages
// ==========================================
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/portfolio', [PageController::class, 'portfolio'])->name('portfolio');
Route::get('/portfolio/{slug}', [PageController::class, 'portfolioProject'])->name('portfolio.show');
Route::get('/pricing', [PageController::class, 'pricing'])->name('pricing');
Route::get('/blog', [PageController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [PageController::class, 'blogPost'])->name('blog.show');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');

// Dynamic Form Submissions
Route::post('/contact', [InquiryController::class, 'storeContact'])->middleware('throttle:5,1')->name('contact.store');
Route::post('/quote', [InquiryController::class, 'storeQuote'])->middleware('throttle:5,1')->name('quote.store');

// Global login route redirect
Route::get('/login', fn () => redirect()->route('admin.login'))->name('login');

// ==========================================
// Admin Back-Office Routes
// ==========================================
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest Admin Auth
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::get('/captcha/refresh', [AuthController::class, 'refreshCaptcha'])->name('captcha.refresh');
        Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.post');
    });

    // Protected Admin Panel
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
        Route::put('/profile/password', [AuthController::class, 'updatePassword'])->name('profile.password');
        Route::get('/', [DashboardController::class, 'index'])->name('root');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity_logs.index');

        // Inquiry & Lead Management
        Route::get('/inquiries/export', [InquiryAdminController::class, 'export'])->name('inquiries.export');
        Route::get('/inquiries/{inquiry}/pdf', [InquiryAdminController::class, 'downloadPdf'])->name('inquiries.pdf');
        Route::get('/inquiries', [InquiryAdminController::class, 'index'])->name('inquiries.index');
        Route::patch('/inquiries/{inquiry}/status', [InquiryAdminController::class, 'updateStatus'])->name('inquiries.status');
        Route::delete('/inquiries/{inquiry}', [InquiryAdminController::class, 'destroy'])->name('inquiries.destroy');

        // Dynamic Categories
        Route::post('/categories', [CategoryAdminController::class, 'store'])->name('categories.store');

        // Services Module
        Route::get('/services', [ServiceAdminController::class, 'index'])->name('services.index');
        Route::post('/services', [ServiceAdminController::class, 'store'])->name('services.store');
        Route::put('/services/{service}', [ServiceAdminController::class, 'update'])->name('services.update');
        Route::patch('/services/{service}/toggle', [ServiceAdminController::class, 'toggle'])->name('services.toggle');
        Route::delete('/services/{service}', [ServiceAdminController::class, 'destroy'])->name('services.destroy');

        // Products Module
        Route::get('/products', [ProductAdminController::class, 'index'])->name('products.index');
        Route::post('/products', [ProductAdminController::class, 'store'])->name('products.store');
        Route::put('/products/{product}', [ProductAdminController::class, 'update'])->name('products.update');
        Route::patch('/products/{product}/toggle', [ProductAdminController::class, 'toggle'])->name('products.toggle');
        Route::delete('/products/{product}', [ProductAdminController::class, 'destroy'])->name('products.destroy');

        // Portfolio Projects Module
        Route::get('/portfolio', [PortfolioAdminController::class, 'index'])->name('portfolio.index');
        Route::post('/portfolio', [PortfolioAdminController::class, 'store'])->name('portfolio.store');
        Route::put('/portfolio/{project}', [PortfolioAdminController::class, 'update'])->name('portfolio.update');
        Route::patch('/portfolio/{project}/toggle', [PortfolioAdminController::class, 'toggle'])->name('portfolio.toggle');
        Route::delete('/portfolio/{project}', [PortfolioAdminController::class, 'destroy'])->name('portfolio.destroy');

        // Tech Blog Posts Module
        Route::get('/blog-posts', [BlogPostAdminController::class, 'index'])->name('blog_posts.index');
        Route::post('/blog-posts', [BlogPostAdminController::class, 'store'])->name('blog_posts.store');
        Route::put('/blog-posts/{post}', [BlogPostAdminController::class, 'update'])->name('blog_posts.update');
        Route::patch('/blog-posts/{post}/toggle', [BlogPostAdminController::class, 'toggle'])->name('blog_posts.toggle');
        Route::delete('/blog-posts/{post}', [BlogPostAdminController::class, 'destroy'])->name('blog_posts.destroy');

        // Pricing Plans Module
        Route::get('/pricing-plans', [PricingPlanAdminController::class, 'index'])->name('pricing_plans.index');
        Route::post('/pricing-plans', [PricingPlanAdminController::class, 'store'])->name('pricing_plans.store');
        Route::put('/pricing-plans/{plan}', [PricingPlanAdminController::class, 'update'])->name('pricing_plans.update');
        Route::patch('/pricing-plans/{plan}/toggle', [PricingPlanAdminController::class, 'toggle'])->name('pricing_plans.toggle');
        Route::delete('/pricing-plans/{plan}', [PricingPlanAdminController::class, 'destroy'])->name('pricing_plans.destroy');

        // Client Testimonials Module
        Route::get('/testimonials', [TestimonialAdminController::class, 'index'])->name('testimonials.index');
        Route::post('/testimonials', [TestimonialAdminController::class, 'store'])->name('testimonials.store');
        Route::put('/testimonials/{testimonial}', [TestimonialAdminController::class, 'update'])->name('testimonials.update');
        Route::delete('/testimonials/{testimonial}', [TestimonialAdminController::class, 'destroy'])->name('testimonials.destroy');

        // Team Members Module
        Route::get('/team-members', [TeamMemberAdminController::class, 'index'])->name('team_members.index');
        Route::post('/team-members', [TeamMemberAdminController::class, 'store'])->name('team_members.store');
        Route::put('/team-members/{teamMember}', [TeamMemberAdminController::class, 'update'])->name('team_members.update');
        Route::delete('/team-members/{teamMember}', [TeamMemberAdminController::class, 'destroy'])->name('team_members.destroy');

        // FAQ Knowledgebase Module
        Route::get('/faqs', [FaqAdminController::class, 'index'])->name('faqs.index');
        Route::post('/faqs', [FaqAdminController::class, 'store'])->name('faqs.store');
        Route::put('/faqs/{faq}', [FaqAdminController::class, 'update'])->name('faqs.update');
        Route::delete('/faqs/{faq}', [FaqAdminController::class, 'destroy'])->name('faqs.destroy');

        // User & Role Management (RBAC) Module
        Route::get('/users/export', [UserAdminController::class, 'export'])->name('users.export');
        Route::get('/users', [UserAdminController::class, 'index'])->name('users.index');
        Route::post('/users', [UserAdminController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UserAdminController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserAdminController::class, 'destroy'])->name('users.destroy');

        // Site Settings Module
        Route::get('/settings', [SettingAdminController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingAdminController::class, 'update'])->name('settings.update');

        // Media Upload API (Intervention WebP)
        Route::post('/media/upload', [MediaUploadController::class, 'upload'])->name('media.upload');
    });
});
