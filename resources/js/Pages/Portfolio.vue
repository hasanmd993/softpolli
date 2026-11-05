<template>
  <MainLayout>
    <Head title="Client Portfolio & Enterprise Case Studies" />

    <!-- ============ PORTFOLIO HERO ============ -->
    <section class="bg-navy-950 text-white py-20 relative overflow-hidden">
      <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6 relative z-10 text-center">
        <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-brand/20 border border-brand/40 text-brand-light text-xs font-bold uppercase tracking-wider mb-5">
          <i class="fa-solid fa-briefcase"></i> Proven Track Record
        </span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-white leading-tight mb-6 max-w-3xl mx-auto">
          Delivering Digital Products That <span class="text-brand">Move Real Businesses</span>
        </h1>
        <p class="text-slate-300 text-xs sm:text-sm leading-relaxed max-w-xl mx-auto mb-10">
          Explore our completed systems across retail, transport ticketing, event management, and enterprise content publishing.
        </p>

        <!-- Category Filters -->
        <div class="flex flex-wrap items-center justify-center gap-2">
          <button
            v-for="cat in categories"
            :key="cat"
            @click="activeCategory = cat"
            class="px-5 py-2.5 rounded-full text-xs font-semibold transition"
            :class="activeCategory === cat ? 'bg-brand text-white shadow-md shadow-brand/25' : 'bg-navy-900 border border-slate-800 text-slate-400 hover:text-white'"
          >
            {{ cat }}
          </button>
        </div>
      </div>
    </section>

    <!-- ============ PROJECTS GRID ============ -->
    <section class="py-24 bg-slate-50">
      <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6 space-y-16">
        <article
          v-for="(project, i) in filteredProjects"
          :key="project.id"
          class="bg-white rounded-3xl p-6 sm:p-10 lg:p-12 border border-slate-200/80 shadow-md hover:shadow-xl transition-all duration-300 grid lg:grid-cols-2 gap-8 lg:gap-10 items-center"
        >
          <div :class="i % 2 === 1 ? 'lg:order-2' : ''">
            <div class="flex items-center gap-3 text-xs text-brand font-bold mb-2 uppercase">
              <span>{{ project.number }}</span>
              <span>&bull;</span>
              <span>{{ project.category }}</span>
            </div>
            <Link :href="`/portfolio/${project.slug}`" class="block group/title">
              <h3 class="text-2xl sm:text-3xl font-extrabold text-navy-900 group-hover/title:text-brand transition mb-3 leading-snug">
                {{ project.title }} &mdash; {{ project.tagline }}
              </h3>
            </Link>
            <div class="text-xs sm:text-sm text-slate-500 leading-relaxed mb-6 prose prose-xs sm:prose-sm max-w-none prose-slate [&_p]:mb-2 [&_ul]:list-disc [&_ul]:ml-4" v-html="sanitizeHtml(project.description)"></div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between text-xs mb-8">
              <span class="font-bold text-navy-900">Key Performance Metric:</span>
              <span class="text-brand font-extrabold flex items-center gap-1.5">
                <i class="fa-solid fa-chart-line"></i> {{ project.metrics }}
              </span>
            </div>

            <div class="flex flex-wrap items-center gap-4">
              <Link
                :href="`/portfolio/${project.slug}`"
                class="inline-flex items-center gap-2 bg-navy-900 hover:bg-brand text-white text-xs font-bold px-6 py-3 rounded-full transition shadow-md"
              >
                Case Study <i class="fa-solid fa-arrow-right text-[10px]"></i>
              </Link>
              <a
                v-if="project.live_url && project.live_url !== '#'"
                :href="project.live_url"
                target="_blank"
                class="inline-flex items-center gap-2 bg-brand hover:bg-brand-light text-white text-xs font-bold px-6 py-3 rounded-full transition shadow-md shadow-brand/20"
              >
                Launch Live App <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
              </a>
              <Link
                href="/contact"
                class="inline-flex items-center gap-2 border border-slate-200 hover:border-brand hover:text-brand text-xs font-semibold px-6 py-3 rounded-full transition"
              >
                Inquire Similar Solution <i class="fa-solid fa-arrow-right text-[10px]"></i>
              </Link>
            </div>
          </div>

          <Link
            :href="`/portfolio/${project.slug}`"
            :class="i % 2 === 1 ? 'lg:order-1' : ''"
            class="rounded-2xl overflow-hidden shadow-lg h-[280px] sm:h-[340px] border border-slate-100 group block relative"
          >
            <img
              :src="project.image"
              :alt="project.title"
              class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
            />
            <div class="absolute inset-0 bg-navy-950/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
              <span class="bg-white/90 backdrop-blur text-navy-950 font-bold text-xs px-4 py-2 rounded-full shadow">View Case Study</span>
            </div>
          </Link>
        </article>
      </div>
    </section>
  </MainLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import { sanitizeHtml } from '@/Utils/sanitize';

const props = defineProps({
  projects: Array,
});

const activeCategory = ref('All');

const categories = [
  'All',
  'Retail & Restaurant Tech',
  'Transport & Ticketing',
  'Smart Home & Events',
  'Publishing & Media',
];

const filteredProjects = computed(() => {
  if (activeCategory.value === 'All') {
    return props.projects || [];
  }
  return (props.projects || []).filter((p) => p.category === activeCategory.value);
});
</script>
