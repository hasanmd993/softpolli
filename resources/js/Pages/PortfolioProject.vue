<template>
  <MainLayout>
    <MetaHead
      :title="`${project.title} — Case Study`"
      :description="project.tagline || project.title"
      :image="project.image || '/images/SP-logo.png'"
      type="article"
    />

    <!-- Hero Header -->
    <section class="bg-navy-950 text-white pt-24 pb-16 relative overflow-hidden border-b border-slate-800">
      <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#f1592a_1px,transparent_1px)] [background-size:24px_24px]"></div>

      <div class="max-w-4xl mx-auto px-6 relative z-10">
        <!-- Breadcrumb / Back Link -->
        <Link
          href="/portfolio"
          class="inline-flex items-center gap-2 text-xs font-semibold text-slate-400 hover:text-brand transition mb-6"
        >
          <i class="fa-solid fa-arrow-left text-[10px]"></i> Back to all portfolio projects
        </Link>

        <!-- Category & Number -->
        <div class="flex flex-wrap items-center gap-3 mb-4">
          <span class="px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-brand/20 text-brand-light border border-brand/40">
            {{ project.category }}
          </span>
          <span v-if="project.number" class="text-xs text-slate-400 font-mono">
            Project #{{ project.number }}
          </span>
        </div>

        <!-- Project Title & Tagline -->
        <h1 class="text-2xl sm:text-4xl lg:text-5xl font-extrabold text-white leading-tight mb-4">
          {{ project.title }}
        </h1>
        <p v-if="project.tagline" class="text-base sm:text-xl text-slate-300 font-medium leading-relaxed">
          {{ project.tagline }}
        </p>

        <!-- Metric Highlight & Actions -->
        <div class="flex flex-wrap items-center justify-between gap-4 mt-8 pt-6 border-t border-slate-800/80">
          <div v-if="project.metrics" class="flex items-center gap-2 text-brand text-sm sm:text-base font-extrabold">
            <i class="fa-solid fa-chart-line text-lg"></i>
            <span>{{ project.metrics }}</span>
          </div>
          <div class="flex flex-wrap items-center gap-3">
            <a
              v-if="project.live_url && project.live_url !== '#'"
              :href="project.live_url"
              target="_blank"
              rel="noopener noreferrer"
              class="inline-flex items-center gap-2 bg-brand hover:bg-brand-light text-white text-xs font-bold px-6 py-3 rounded-full transition shadow-lg shadow-brand/25"
            >
              Launch Live App <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
            </a>
            <Link
              href="/contact"
              class="inline-flex items-center gap-2 border border-slate-700 hover:border-brand hover:text-brand text-white text-xs font-semibold px-6 py-3 rounded-full transition"
            >
              Request Similar Project <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </Link>
          </div>
        </div>
      </div>
    </section>

    <!-- Case Study Body -->
    <article class="py-16 bg-white text-slate-800">
      <div class="max-w-4xl mx-auto px-6">
        <!-- Featured Image -->
        <div v-if="project.image" class="mb-12 rounded-3xl overflow-hidden shadow-2xl border border-slate-100 max-h-[500px]">
          <img
            :src="project.image"
            :alt="project.title"
            class="w-full h-full object-cover object-center max-h-[500px]"
            loading="lazy"
          />
        </div>

        <!-- Social Share Bar -->
        <div class="flex flex-wrap items-center justify-between gap-4 py-4 mb-10 border-y border-slate-100 text-xs text-slate-500">
          <span class="font-bold uppercase tracking-wider text-[11px] text-slate-400">Share this case study:</span>
          <div class="flex items-center gap-2">
            <a
              :href="`https://twitter.com/intent/tweet?text=${encodeURIComponent(project.title)}&url=${encodeURIComponent(currentUrl)}`"
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
              @click="copyUrl"
              class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-800 hover:text-white transition grid place-items-center"
              :title="copied ? 'Copied!' : 'Copy Link'"
            >
              <i class="fa-solid" :class="copied ? 'fa-check text-green-500' : 'fa-link'"></i>
            </button>
          </div>
        </div>

        <!-- Project Overview / Description Content -->
        <div
          class="prose prose-slate max-w-none text-slate-600 leading-relaxed text-sm sm:text-base [&_p]:mb-4 [&_h2]:text-2xl [&_h2]:font-extrabold [&_h2]:text-navy-900 [&_h2]:mt-8 [&_h2]:mb-4 [&_h3]:text-xl [&_h3]:font-bold [&_h3]:text-navy-900 [&_h3]:mt-6 [&_h3]:mb-3 [&_ul]:list-disc [&_ul]:ml-6 [&_ul]:mb-4 [&_ol]:list-decimal [&_ol]:ml-6 [&_ol]:mb-4 [&_li]:mb-1 [&_strong]:text-navy-900"
          v-html="sanitizeHtml(project.description)"
        ></div>

        <!-- CTA Box -->
        <div class="mt-16 p-8 sm:p-12 rounded-3xl bg-gradient-to-br from-navy-950 to-navy-900 text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-6 border border-brand/20">
          <div>
            <span class="text-xs font-bold text-brand uppercase tracking-wider">Start A Similar Project</span>
            <h3 class="text-xl sm:text-2xl font-extrabold text-white mt-1">Need a solution engineered for your business?</h3>
            <p class="text-xs sm:text-sm text-slate-300 mt-2 max-w-lg">
              Let our senior engineering team design and deliver an enterprise platform tailored to your workflow and scale.
            </p>
          </div>
          <Link
            href="/contact"
            class="shrink-0 inline-flex items-center gap-2 bg-brand hover:bg-brand-light text-white text-xs sm:text-sm font-bold px-7 py-4 rounded-full transition shadow-lg shadow-brand/25"
          >
            Get In Touch <i class="fa-solid fa-arrow-right text-xs"></i>
          </Link>
        </div>
      </div>
    </article>

    <!-- Related Projects Section -->
    <section v-if="relatedProjects && relatedProjects.length > 0" class="py-20 bg-slate-50 border-t border-slate-200/80">
      <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6">
        <div class="flex items-center justify-between mb-12">
          <div>
            <p class="text-brand font-bold tracking-[0.2em] text-xs uppercase mb-2">More Case Studies</p>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-navy-900">Explore Related Projects</h2>
          </div>
          <Link
            href="/portfolio"
            class="hidden sm:inline-flex items-center gap-2 text-xs font-bold text-navy-900 hover:text-brand transition"
          >
            View All Projects <i class="fa-solid fa-arrow-right text-xs"></i>
          </Link>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div
            v-for="rel in relatedProjects"
            :key="rel.id"
            class="bg-white rounded-3xl overflow-hidden border border-slate-200/80 shadow-md hover:shadow-xl transition flex flex-col"
          >
            <div class="h-48 overflow-hidden bg-slate-100">
              <img
                :src="rel.image"
                :alt="rel.title"
                class="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
                loading="lazy"
              />
            </div>
            <div class="p-6 flex-1 flex flex-col justify-between">
              <div>
                <span class="text-[11px] font-bold text-brand uppercase tracking-wider mb-1 block">{{ rel.category }}</span>
                <Link :href="`/portfolio/${rel.slug}`" class="block group">
                  <h3 class="font-bold text-lg text-navy-900 group-hover:text-brand transition mb-2 line-clamp-1">{{ rel.title }}</h3>
                </Link>
                <p class="text-xs text-slate-500 line-clamp-2 mb-4">{{ rel.tagline }}</p>
              </div>
              <Link
                :href="`/portfolio/${rel.slug}`"
                class="inline-flex items-center gap-1.5 text-xs font-bold text-brand hover:translate-x-1 transition-transform"
              >
                Read Case Study <i class="fa-solid fa-arrow-right text-[10px]"></i>
              </Link>
            </div>
          </div>
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
  project: {
    type: Object,
    required: true,
  },
  relatedProjects: {
    type: Array,
    default: () => [],
  },
});

const copied = ref(false);

const currentUrl = computed(() => {
  if (typeof window !== 'undefined') {
    return window.location.href;
  }
  return `https://softpolli.com/portfolio/${props.project.slug}`;
});

const copyUrl = async () => {
  if (typeof navigator !== 'undefined' && navigator.clipboard) {
    try {
      await navigator.clipboard.writeText(currentUrl.value);
      copied.value = true;
      setTimeout(() => {
        copied.value = false;
      }, 2500);
    } catch {
      // ignore
    }
  }
};
</script>

