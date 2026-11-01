<template>
  <MainLayout>
    <Head title="Custom Software & Enterprise IT Services" />

    <!-- ============ SERVICES HERO ============ -->
    <section class="bg-navy-950 text-white py-20 relative overflow-hidden">
      <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6 relative z-10 text-center">
        <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-brand/20 border border-brand/40 text-brand-light text-xs font-bold uppercase tracking-wider mb-5">
          <i class="fa-solid fa-layer-group"></i> Full-Lifecycle Engineering
        </span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-white leading-tight mb-6 max-w-3xl mx-auto">
          Enterprise Services Designed To <span class="text-brand">Power Your Business</span>
        </h1>
        <p class="text-slate-300 text-xs sm:text-sm leading-relaxed max-w-xl mx-auto mb-8">
          From complex ERP systems and point of sale automation to secure cloud architectures, we engineer software built for extreme reliability and growth.
        </p>
        <Link href="/contact" class="inline-flex items-center gap-2 bg-brand hover:bg-brand-light text-white text-xs sm:text-sm font-bold px-8 py-4 rounded-full transition shadow-lg shadow-brand/25">
          Request A Service Consultation <i class="fa-solid fa-arrow-right text-xs"></i>
        </Link>
      </div>
    </section>

    <!-- ============ SERVICES GRID ============ -->
    <section class="py-24 bg-white">
      <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div
            v-for="service in services"
            :key="service.id"
            class="rounded-3xl border border-slate-100 overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 flex flex-col justify-between group bg-slate-50/50"
          >
            <div>
              <div class="h-48 overflow-hidden relative">
                <img
                  :src="service.image"
                  :alt="service.title"
                  class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                />
                <span class="absolute top-4 left-4 bg-navy-950/80 backdrop-blur-md text-brand text-[10px] font-extrabold uppercase px-3 py-1 rounded-full">
                  {{ service.tag }}
                </span>
              </div>
              <div class="p-8">
                <h3 class="text-xl font-extrabold text-navy-900 mb-3 group-hover:text-brand transition">
                  {{ service.title }}
                </h3>
                <div class="text-xs text-slate-500 leading-relaxed mb-6 prose prose-xs max-w-none prose-slate [&_p]:mb-2 [&_ul]:list-disc [&_ul]:ml-4" v-html="sanitizeHtml(service.description)"></div>
              </div>
            </div>

            <div class="p-8 pt-0">
              <Link
                href="/contact"
                class="inline-flex items-center gap-2 text-xs font-bold text-brand hover:translate-x-1 transition-transform"
              >
                Inquire About Service <i class="fa-solid fa-arrow-right text-[10px]"></i>
              </Link>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ============ 5-STEP ENGINEERING PROCESS ============ -->
    <section class="py-24 bg-slate-50 border-t border-slate-100">
      <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6">
        <div class="text-center max-w-xl mx-auto mb-16">
          <p class="text-brand font-bold tracking-[0.2em] text-xs uppercase mb-3 relative inline-block">
            DELIVERY LIFECYCLE
            <span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-8 h-[2px] bg-brand"></span>
          </p>
          <h2 class="text-3xl sm:text-4xl font-extrabold text-navy-900">
            How We Build Your Software
          </h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
          <div
            v-for="(step, idx) in steps"
            :key="idx"
            class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm relative flex flex-col justify-between"
          >
            <div>
              <span class="text-3xl font-extrabold text-brand/30 block mb-4">0{{ idx + 1 }}.</span>
              <h4 class="font-bold text-sm text-navy-900 mb-2">{{ step.title }}</h4>
              <p class="text-xs text-slate-500 leading-relaxed">{{ step.desc }}</p>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100 text-[11px] text-brand font-semibold">
              <i class="fa-solid fa-circle-check text-[10px] mr-1"></i> {{ step.badge }}
            </div>
          </div>
        </div>
      </div>
    </section>
  </MainLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import { sanitizeHtml } from '@/Utils/sanitize';

defineProps({
  services: Array,
});

const steps = [
  { title: 'Discovery & Scope', desc: 'Understanding your business challenges, database needs, and edge cases.', badge: 'Formal Specs' },
  { title: 'Architecture & UI', desc: 'Interactive prototypes, database schema modeling, and UX flows.', badge: 'Figma & DB Design' },
  { title: 'Agile Development', desc: 'Clean, tested code built in rapid 2-week continuous delivery sprints.', badge: 'Laravel & Vue 3' },
  { title: 'Quality & Security', desc: 'Penetration testing, stress tests, and automated browser QA.', badge: 'Zero Regressions' },
  { title: 'Launch & Retainer', desc: 'Zero-downtime cloud deployment, automated backups, and SLA monitoring.', badge: '24/7 SLA Support' },
];
</script>
