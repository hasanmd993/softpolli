<template>
  <MainLayout>
    <Head title="Transparent Software Pricing & Development Packages" />

    <!-- ============ PRICING HERO ============ -->
    <section class="bg-navy-950 text-white py-20 relative overflow-hidden">
      <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6 relative z-10 text-center">
        <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-brand/20 border border-brand/40 text-brand-light text-xs font-bold uppercase tracking-wider mb-5">
          <i class="fa-solid fa-tag"></i> Clear & Transparent Pricing
        </span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-white leading-tight mb-6 max-w-3xl mx-auto">
          Predictable Investments For <span class="text-brand">Scalable Growth</span>
        </h1>
        <p class="text-slate-300 text-xs sm:text-sm leading-relaxed max-w-xl mx-auto mb-10">
          No hidden fees, no licensing lock-ins. You receive full source code ownership, enterprise security standards, and dedicated engineering support.
        </p>

        <!-- Billing Switcher -->
        <div class="inline-flex flex-wrap sm:flex-nowrap items-center justify-center gap-2 sm:gap-4 bg-navy-900 border border-slate-800 p-1.5 rounded-2xl sm:rounded-full shadow-inner max-w-full">
          <button
            @click="isAnnual = false"
            class="px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl sm:rounded-full text-xs font-bold transition"
            :class="!isAnnual ? 'bg-brand text-white shadow' : 'text-slate-400 hover:text-white'"
          >
            Monthly Billing
          </button>
          <button
            @click="isAnnual = true"
            class="px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl sm:rounded-full text-xs font-bold transition flex items-center gap-2"
            :class="isAnnual ? 'bg-brand text-white shadow' : 'text-slate-400 hover:text-white'"
          >
            Annual Billing
            <span class="bg-emerald-500 text-white text-[10px] px-2 py-0.5 rounded-full uppercase font-extrabold">Save 15%</span>
          </button>
        </div>
      </div>
    </section>

    <!-- ============ PRICING CARDS ============ -->
    <section class="py-24 bg-slate-50">
      <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-stretch">
          <div
            v-for="plan in plans"
            :key="plan.name"
            class="rounded-3xl p-8 sm:p-10 transition-all duration-300 flex flex-col justify-between relative bg-white border"
            :class="plan.is_popular ? 'border-brand shadow-2xl ring-2 ring-brand/30 -translate-y-2' : 'border-slate-200 shadow-md hover:shadow-xl'"
          >
            <!-- Popular Badge -->
            <div v-if="plan.is_popular" class="absolute -top-4 left-1/2 -translate-x-1/2 bg-brand text-white text-[11px] font-extrabold px-4 py-1.5 rounded-full uppercase tracking-wider shadow">
              Most Popular Choice
            </div>

            <div>
              <h3 class="text-xl font-extrabold text-navy-900 mb-2">{{ plan.name }}</h3>
              <p class="text-xs text-slate-500 leading-relaxed min-h-[36px] mb-6">{{ plan.audience }}</p>

              <!-- Price Box -->
              <div class="flex items-baseline gap-1 pb-6 mb-6 border-b border-slate-100">
                <span class="text-4xl sm:text-5xl font-extrabold text-navy-900">
                  ${{ isAnnual ? plan.annual_price : plan.monthly_price }}
                </span>
                <span class="text-xs text-slate-500 font-semibold">/ month</span>
              </div>

              <!-- Feature List -->
              <div class="space-y-3.5 mb-8">
                <span class="text-[11px] font-bold text-navy-900 uppercase tracking-wider block">What's Included:</span>
                <div
                  v-for="(feature, idx) in plan.features"
                  :key="idx"
                  class="flex items-start gap-3 text-xs text-slate-600"
                >
                  <i class="fa-solid fa-circle-check text-brand text-sm shrink-0 mt-0.5"></i>
                  <span>{{ feature }}</span>
                </div>
              </div>
            </div>

            <Link
              href="/contact"
              class="w-full py-4 rounded-xl text-xs font-bold text-center transition flex items-center justify-center gap-2"
              :class="plan.is_popular ? 'bg-brand hover:bg-brand-light text-white shadow-lg shadow-brand/25' : 'bg-navy-900 hover:bg-navy-800 text-white'"
            >
              Choose {{ plan.name }} <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </Link>
          </div>
        </div>

        <!-- Custom Enterprise Banner -->
        <div class="mt-16 bg-navy-900 text-white rounded-3xl p-8 sm:p-12 border border-slate-800 flex flex-col md:flex-row items-center justify-between gap-8">
          <div>
            <span class="text-xs font-bold text-brand uppercase tracking-wider">Enterprise & Government</span>
            <h3 class="text-2xl font-extrabold text-white mt-1">Need a custom multi-tenant architecture?</h3>
            <p class="text-xs text-slate-400 mt-2 max-w-xl leading-relaxed">
              We engineer tailored on-premise solutions, custom ERP modules, and dedicated engineering retainers to match your enterprise specifications.
            </p>
          </div>
          <Link
            href="/contact"
            class="shrink-0 bg-brand hover:bg-brand-light text-white text-xs font-bold px-8 py-4 rounded-full transition shadow-lg shadow-brand/25"
          >
            Talk to an Enterprise Architect <i class="fa-solid fa-arrow-right ml-1"></i>
          </Link>
        </div>
      </div>
    </section>

    <!-- ============ FEATURE COMPARISON MATRIX ============ -->
    <section class="py-24 bg-white border-t border-slate-100">
      <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6">
        <div class="text-center max-w-xl mx-auto mb-16">
          <p class="text-brand font-bold tracking-[0.2em] text-xs uppercase mb-3 relative inline-block">
            FEATURE COMPARISON
            <span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-8 h-[2px] bg-brand"></span>
          </p>
          <h2 class="text-3xl sm:text-4xl font-extrabold text-navy-900">
            Compare Plan Capabilities
          </h2>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-xs text-left border-collapse min-w-[650px]">
            <thead>
              <tr class="border-b-2 border-slate-200">
                <th class="py-4 px-4 font-bold text-navy-900 text-sm">Capability / Deliverable</th>
                <th class="py-4 px-4 font-bold text-navy-900 text-center">Starter</th>
                <th class="py-4 px-4 font-bold text-brand text-center">Professional</th>
                <th class="py-4 px-4 font-bold text-navy-900 text-center">Enterprise</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              <tr>
                <td class="py-3.5 px-4 font-medium text-slate-700">100% Full Source Code Ownership</td>
                <td class="py-3.5 px-4 text-center text-brand"><i class="fa-solid fa-check"></i></td>
                <td class="py-3.5 px-4 text-center text-brand"><i class="fa-solid fa-check"></i></td>
                <td class="py-3.5 px-4 text-center text-brand"><i class="fa-solid fa-check"></i></td>
              </tr>
              <tr>
                <td class="py-3.5 px-4 font-medium text-slate-700">Mobile-First Vue 3 SPA Interface</td>
                <td class="py-3.5 px-4 text-center text-brand"><i class="fa-solid fa-check"></i></td>
                <td class="py-3.5 px-4 text-center text-brand"><i class="fa-solid fa-check"></i></td>
                <td class="py-3.5 px-4 text-center text-brand"><i class="fa-solid fa-check"></i></td>
              </tr>
              <tr>
                <td class="py-3.5 px-4 font-medium text-slate-700">Role-Based Access Control (RBAC)</td>
                <td class="py-3.5 px-4 text-center text-slate-300">&mdash;</td>
                <td class="py-3.5 px-4 text-center text-brand"><i class="fa-solid fa-check"></i></td>
                <td class="py-3.5 px-4 text-center text-brand"><i class="fa-solid fa-check"></i></td>
              </tr>
              <tr>
                <td class="py-3.5 px-4 font-medium text-slate-700">Automated Payment Gateway Integration</td>
                <td class="py-3.5 px-4 text-center text-slate-300">&mdash;</td>
                <td class="py-3.5 px-4 text-center text-brand"><i class="fa-solid fa-check"></i></td>
                <td class="py-3.5 px-4 text-center text-brand"><i class="fa-solid fa-check"></i></td>
              </tr>
              <tr>
                <td class="py-3.5 px-4 font-medium text-slate-700">Multi-Branch Real-Time Inventory Sync</td>
                <td class="py-3.5 px-4 text-center text-slate-300">&mdash;</td>
                <td class="py-3.5 px-4 text-center text-slate-300">&mdash;</td>
                <td class="py-3.5 px-4 text-center text-brand"><i class="fa-solid fa-check"></i></td>
              </tr>
              <tr>
                <td class="py-3.5 px-4 font-medium text-slate-700">Offline-First Local Storage Replication</td>
                <td class="py-3.5 px-4 text-center text-slate-300">&mdash;</td>
                <td class="py-3.5 px-4 text-center text-slate-300">&mdash;</td>
                <td class="py-3.5 px-4 text-center text-brand"><i class="fa-solid fa-check"></i></td>
              </tr>
              <tr>
                <td class="py-3.5 px-4 font-medium text-slate-700">Post-Launch Warranty & Support</td>
                <td class="py-3.5 px-4 text-center text-slate-600">30 Days</td>
                <td class="py-3.5 px-4 text-center text-brand font-bold">90 Days</td>
                <td class="py-3.5 px-4 text-center text-navy-900 font-bold">1 Year SLA</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- ============ PRICING FAQS ============ -->
    <FaqSection :faqs="faqs" />
  </MainLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import FaqSection from '@/Components/FaqSection.vue';

defineProps({
  plans: Array,
  faqs: Array,
});

const isAnnual = ref(true);
</script>
