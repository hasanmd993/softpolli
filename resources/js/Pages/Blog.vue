<template>
  <MainLayout>
    <MetaHead
      title="Technology Insights & Software Engineering Blog"
      description="Field notes, software architecture insights, and technical deep dives from the SoftPolli engineering team."
      image="/images/blog1.webp"
    />

    <!-- ============ BLOG HERO ============ -->
    <section class="bg-navy-950 text-white py-20 relative overflow-hidden">
      <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6 relative z-10 text-center">
        <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-brand/20 border border-brand/40 text-brand-light text-xs font-bold uppercase tracking-wider mb-5">
          <i class="fa-solid fa-newspaper"></i> Engineering Insights
        </span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-white leading-tight mb-6 max-w-3xl mx-auto">
          Thoughts on <span class="text-brand">Software Scalability</span>, Architecture & Digital Growth
        </h1>
        <p class="text-slate-300 text-xs sm:text-sm leading-relaxed max-w-xl mx-auto mb-10">
          Field notes, design decisions, and deep dives from our software engineering team in Dhaka.
        </p>

        <!-- Category Filters -->
        <div class="flex flex-wrap items-center justify-center gap-2">
          <button
            v-for="cat in categories"
            :key="cat"
            @click="selectedCategory = cat"
            class="px-5 py-2.5 rounded-full text-xs font-semibold transition"
            :class="selectedCategory === cat ? 'bg-brand text-white shadow-md shadow-brand/25' : 'bg-navy-900 border border-slate-800 text-slate-400 hover:text-white'"
          >
            {{ cat }}
          </button>
        </div>
      </div>
    </section>

    <!-- ============ ARTICLES LIST ============ -->
    <section class="py-24 bg-slate-50">
      <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6">
        <!-- Featured Hero Article -->
        <div v-if="featuredArticle" class="mb-16 bg-white rounded-3xl overflow-hidden shadow-xl border border-slate-100 grid lg:grid-cols-2 items-center">
          <div class="h-64 sm:h-80 lg:h-full min-h-[340px] relative">
            <img :src="featuredArticle.image" :alt="featuredArticle.title" class="w-full h-full object-cover" />
            <div class="absolute top-6 left-6 bg-brand text-white text-[10px] font-extrabold uppercase px-3 py-1.5 rounded-full tracking-wider shadow">
              Featured Insight
            </div>
          </div>
          <div class="p-8 sm:p-12">
            <div class="flex items-center gap-4 text-xs text-slate-400 mb-3">
              <span class="text-brand font-semibold">{{ featuredArticle.category }}</span>
              <span>&bull;</span>
              <span>{{ featuredArticle.date }}</span>
              <span>&bull;</span>
              <span>{{ featuredArticle.read_time }}</span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-navy-900 leading-snug mb-4">
              <Link :href="`/blog/${featuredArticle.slug}`" class="hover:text-brand transition">
                {{ featuredArticle.title }}
              </Link>
            </h2>
            <div class="text-xs sm:text-sm text-slate-500 leading-relaxed mb-6 prose prose-xs sm:prose-sm max-w-none prose-slate [&_p]:mb-1" v-html="sanitizeHtml(featuredArticle.excerpt)"></div>
            <div class="flex items-center justify-between pt-6 border-t border-slate-100">
              <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-brand/10 text-brand flex items-center justify-center font-bold text-xs">
                  {{ featuredArticle.author.charAt(0) }}
                </div>
                <div>
                  <h4 class="font-bold text-xs text-navy-900">{{ featuredArticle.author }}</h4>
                  <p class="text-[10px] text-slate-400">SoftPolli Engineering</p>
                </div>
              </div>
              <Link :href="`/blog/${featuredArticle.slug}`" class="inline-flex items-center gap-1.5 text-xs font-bold text-brand hover:translate-x-1 transition-transform">
                Read Deep Dive <i class="fa-solid fa-arrow-right text-[10px]"></i>
              </Link>
            </div>
          </div>
        </div>

        <!-- 3-Column Articles Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <article
            v-for="article in filteredArticles"
            :key="article.slug"
            class="bg-white rounded-3xl overflow-hidden shadow-md hover:shadow-xl border border-slate-100 transition-all duration-300 flex flex-col justify-between group"
          >
            <div>
              <Link :href="`/blog/${article.slug}`" class="h-48 overflow-hidden relative block">
                <img
                  :src="article.image"
                  :alt="article.title"
                  class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                />
                <span class="absolute top-4 left-4 bg-navy-950/80 backdrop-blur-md text-white text-[10px] font-bold px-3 py-1 rounded-full">
                  {{ article.category }}
                </span>
              </Link>
              <div class="p-7">
                <div class="flex items-center gap-3 text-[11px] text-slate-400 mb-2">
                  <span>{{ article.date }}</span>
                  <span>&bull;</span>
                  <span>{{ article.read_time }}</span>
                </div>
                <h3 class="text-base font-bold text-navy-900 leading-snug mb-3 group-hover:text-brand transition">
                  <Link :href="`/blog/${article.slug}`">{{ article.title }}</Link>
                </h3>
                <div class="text-xs text-slate-500 leading-relaxed line-clamp-3 prose prose-xs max-w-none prose-slate [&_p]:mb-1" v-html="sanitizeHtml(article.excerpt)"></div>
              </div>
            </div>

            <div class="p-7 pt-0 flex items-center justify-between border-t border-slate-50 mt-4">
              <span class="text-xs font-medium text-slate-400">By {{ article.author }}</span>
              <Link :href="`/blog/${article.slug}`" class="inline-flex items-center gap-1 text-xs font-bold text-brand group-hover:translate-x-1 transition-transform">
                Read More <i class="fa-solid fa-arrow-right text-[10px]"></i>
              </Link>
            </div>
          </article>
        </div>
      </div>
    </section>
  </MainLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import MetaHead from '@/Components/MetaHead.vue';
import { sanitizeHtml } from '@/Utils/sanitize';

const props = defineProps({
  articles: Array,
});

const selectedCategory = ref('All');

const categories = [
  'All',
  'Software Engineering',
  'Web Architecture',
  'Retail Tech',
];

const featuredArticle = computed(() => {
  return props.articles?.[0] || null;
});

const filteredArticles = computed(() => {
  if (selectedCategory.value === 'All') {
    return props.articles || [];
  }
  return (props.articles || []).filter((a) => a.category === selectedCategory.value);
});
</script>
