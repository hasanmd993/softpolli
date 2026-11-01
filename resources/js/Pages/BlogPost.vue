<template>
  <MainLayout>
    <MetaHead :title="post.title" :description="post.excerpt || post.title" :image="post.image || '/images/SP-logo.png'" type="article" />

    <!-- Article Hero Banner -->
    <section class="bg-navy-950 text-white pt-24 pb-16 relative overflow-hidden border-b border-slate-800">
      <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#f1592a_1px,transparent_1px)] [background-size:24px_24px]"></div>

      <div class="max-w-4xl mx-auto px-6 relative z-10">
        <!-- Breadcrumb / Back Link -->
        <Link
          href="/blog"
          class="inline-flex items-center gap-2 text-xs font-semibold text-slate-400 hover:text-brand transition mb-6"
        >
          <i class="fa-solid fa-arrow-left text-[10px]"></i> Back to all articles
        </Link>

        <!-- Category & Read Time -->
        <div class="flex flex-wrap items-center gap-3 mb-4">
          <span class="px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-brand/20 text-brand-light border border-brand/40">
            {{ post.category }}
          </span>
          <span class="text-xs text-slate-400 flex items-center gap-1.5">
            <i class="fa-regular fa-clock text-brand"></i> {{ post.read_time || '5 min read' }}
          </span>
          <span class="text-xs text-slate-400 flex items-center gap-1.5">
            <i class="fa-regular fa-calendar text-slate-400"></i> {{ post.date }}
          </span>
        </div>

        <!-- Article Title -->
        <h1 class="text-2xl sm:text-4xl lg:text-5xl font-extrabold text-white leading-tight mb-6">
          {{ post.title }}
        </h1>

        <!-- Author Byline -->
        <div class="flex items-center gap-3 pt-4 border-t border-slate-800/80">
          <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-brand to-orange-400 text-white font-bold grid place-items-center text-sm shadow">
            {{ authorInitial }}
          </div>
          <div>
            <p class="text-sm font-bold text-white">{{ post.author }}</p>
            <p class="text-xs text-slate-400">Engineering & Tech Team at SoftPolli</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Main Content Area -->
    <article class="py-12 bg-white text-slate-800">
      <div class="max-w-4xl mx-auto px-6">
        <!-- Featured Image -->
        <div v-if="post.image" class="mb-10 rounded-3xl overflow-hidden shadow-xl border border-slate-100 max-h-[480px]">
          <img
            :src="post.image"
            :alt="post.title"
            class="w-full h-full object-cover object-center max-h-[480px]"
            loading="lazy"
          />
        </div>

        <!-- Article Summary / Lead Paragraph -->
        <div
          v-if="post.excerpt"
          class="text-lg sm:text-xl font-medium text-slate-700 leading-relaxed mb-8 p-6 rounded-2xl bg-slate-50 border-l-4 border-brand"
          v-html="sanitizeHtml(post.excerpt)"
        ></div>

        <!-- Social Share Bar & Actions -->
        <div class="flex flex-wrap items-center justify-between gap-4 py-4 mb-8 border-y border-slate-100 text-xs text-slate-500">
          <span class="font-bold uppercase tracking-wider text-[11px] text-slate-400">Share this article:</span>
          <div class="flex items-center gap-2">
            <a
              :href="`https://twitter.com/intent/tweet?text=${encodeURIComponent(post.title)}&url=${encodeURIComponent(currentUrl)}`"
              target="_blank"
              rel="noopener noreferrer"
              class="w-8 h-8 rounded-full bg-slate-100 hover:bg-sky-500 hover:text-white transition grid place-items-center"
              title="Share on X"
            >
              <i class="fa-brands fa-x-twitter"></i>
            </a>
            <a
              :href="`https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(currentUrl)}`"
              target="_blank"
              rel="noopener noreferrer"
              class="w-8 h-8 rounded-full bg-slate-100 hover:bg-blue-600 hover:text-white transition grid place-items-center"
              title="Share on LinkedIn"
            >
              <i class="fa-brands fa-linkedin-in"></i>
            </a>
            <a
              :href="`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(currentUrl)}`"
              target="_blank"
              rel="noopener noreferrer"
              class="w-8 h-8 rounded-full bg-slate-100 hover:bg-blue-700 hover:text-white transition grid place-items-center"
              title="Share on Facebook"
            >
              <i class="fa-brands fa-facebook-f"></i>
            </a>
            <button
              @click="copyLink"
              class="px-3 py-1.5 rounded-full bg-slate-100 hover:bg-brand hover:text-white transition font-semibold text-[11px] flex items-center gap-1.5"
            >
              <i class="fa-solid fa-link"></i> {{ copied ? 'Copied!' : 'Copy Link' }}
            </button>
          </div>
        </div>

        <!-- Article Body with Sanitized Content -->
        <div
          class="prose prose-slate max-w-none prose-headings:font-extrabold prose-headings:text-slate-900 prose-p:leading-relaxed prose-p:text-slate-700 prose-a:text-brand prose-img:rounded-2xl"
          v-html="sanitizeHtml(post.content || post.excerpt)"
        ></div>

        <!-- Author Bio Card -->
        <div class="mt-14 p-6 sm:p-8 rounded-3xl bg-slate-50 border border-slate-200/80 flex flex-col sm:flex-row items-center gap-6">
          <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-brand to-orange-400 text-white font-extrabold text-xl grid place-items-center shrink-0 shadow-md">
            {{ authorInitial }}
          </div>
          <div class="text-center sm:text-left">
            <h4 class="text-base font-bold text-slate-900">Written by {{ post.author }}</h4>
            <p class="text-xs sm:text-sm text-slate-600 mt-1 leading-relaxed">
              Software architect and engineering contributor at SoftPolli. Specializing in high-performance web systems, cloud infrastructure, and modern customer experience platforms.
            </p>
          </div>
        </div>

        <!-- CTA Box -->
        <div class="mt-12 p-8 rounded-3xl bg-gradient-to-br from-navy-950 to-slate-900 text-white text-center relative overflow-hidden">
          <div class="relative z-10 max-w-lg mx-auto">
            <h3 class="text-xl sm:text-2xl font-bold mb-3">Ready to build your next project?</h3>
            <p class="text-xs sm:text-sm text-slate-300 mb-6">
              Let's turn ideas into robust, production-ready software systems with our expert Dhaka engineering team.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-3">
              <Link
                href="/contact"
                class="px-6 py-3 rounded-xl bg-brand text-white font-bold text-xs uppercase tracking-wider hover:bg-brand-dark transition shadow-lg shadow-brand/25"
              >
                Get Free Consultation
              </Link>
              <Link
                href="/portfolio"
                class="px-6 py-3 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs uppercase tracking-wider transition"
              >
                View Our Work
              </Link>
            </div>
          </div>
        </div>
      </div>
    </article>

    <!-- Related Articles Section -->
    <section v-if="relatedPosts && relatedPosts.length > 0" class="py-16 bg-slate-50 border-t border-slate-200">
      <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6">
        <div class="flex items-center justify-between mb-8">
          <div>
            <span class="text-xs font-bold text-brand uppercase tracking-wider">Keep Reading</span>
            <h3 class="text-2xl font-extrabold text-slate-900">Related Articles</h3>
          </div>
          <Link href="/blog" class="text-xs font-bold text-brand hover:underline flex items-center gap-1">
            All Articles &rarr;
          </Link>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <article
            v-for="rel in relatedPosts"
            :key="rel.id"
            class="bg-white rounded-3xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-md transition flex flex-col group"
          >
            <div class="h-44 overflow-hidden relative bg-slate-100">
              <img
                :src="rel.image || '/images/blog1.webp'"
                :alt="rel.title"
                class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                loading="lazy"
              />
              <span class="absolute top-3 left-3 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-navy-950/80 backdrop-blur-sm text-white">
                {{ rel.category }}
              </span>
            </div>

            <div class="p-5 flex-1 flex flex-col justify-between">
              <div>
                <span class="text-[11px] text-slate-400 block mb-2">{{ rel.date }} &bull; {{ rel.read_time }}</span>
                <h4 class="font-bold text-slate-900 text-sm line-clamp-2 group-hover:text-brand transition mb-2">
                  <Link :href="`/blog/${rel.slug}`">{{ rel.title }}</Link>
                </h4>
                <p class="text-xs text-slate-500 line-clamp-2" v-html="sanitizeHtml(rel.excerpt)"></p>
              </div>

              <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-[11px] font-semibold text-slate-600">{{ rel.author }}</span>
                <Link
                  :href="`/blog/${rel.slug}`"
                  class="text-xs font-bold text-brand group-hover:translate-x-0.5 transition inline-flex items-center gap-1"
                >
                  Read &rarr;
                </Link>
              </div>
            </div>
          </article>
        </div>
      </div>
    </section>
  </MainLayout>
</template>

<script setup>
import { computed, ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import MetaHead from '@/Components/MetaHead.vue';
import { sanitizeHtml } from '@/Utils/sanitize';

const props = defineProps({
  post: Object,
  relatedPosts: Array,
});

const authorInitial = computed(() => {
  return props.post?.author ? props.post.author.charAt(0).toUpperCase() : 'S';
});

const currentUrl = computed(() => {
  if (typeof window !== 'undefined') {
    return window.location.href;
  }
  return '';
});

const copied = ref(false);

const copyLink = async () => {
  if (typeof navigator !== 'undefined' && navigator.clipboard) {
    try {
      await navigator.clipboard.writeText(window.location.href);
      copied.value = true;
      setTimeout(() => {
        copied.value = false;
      }, 2000);
    } catch {
      // ignore
    }
  }
};
</script>
