<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_projects', function (Blueprint $table) {
            $table->id();
            $table->string('number', 10);
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category');
            $table->string('tagline');
            $table->text('description');
            $table->string('image');
            $table->string('live_url')->default('#');
            $table->string('metrics')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_featured')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_projects');
    }
};
