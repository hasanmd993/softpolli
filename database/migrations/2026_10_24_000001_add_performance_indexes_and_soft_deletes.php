<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations to add missing performance indexes and soft deletes.
     */
    public function up(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->softDeletes()->after('status');
            $table->index(['status', 'type']);
            $table->index('created_at');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->index(['is_active', 'sort_order']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->index(['is_active', 'sort_order']);
        });

        Schema::table('portfolio_projects', function (Blueprint $table) {
            $table->index(['is_featured', 'sort_order']);
        });

        Schema::table('blog_posts', function (Blueprint $table) {
            $table->index(['is_published', 'id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropIndex(['is_published', 'id']);
        });

        Schema::table('portfolio_projects', function (Blueprint $table) {
            $table->dropIndex(['is_featured', 'sort_order']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'sort_order']);
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'sort_order']);
        });

        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropIndex(['status', 'type']);
            $table->dropIndex(['created_at']);
            $table->dropSoftDeletes();
        });
    }
};
