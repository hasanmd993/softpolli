<template>
  <MainLayout>
    <Head title="About SoftPolli - Engineering Philosophy & Leadership" />

    <!-- ============ ABOUT HERO ============ -->
    <section class="bg-navy-950 text-white py-20 relative overflow-hidden">
      <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6 relative z-10 text-center">
        <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-brand/20 border border-brand/40 text-brand-light text-xs font-bold uppercase tracking-wider mb-5">
          <i class="fa-solid fa-users"></i> Who We Are
        </span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-white leading-tight mb-6 max-w-3xl mx-auto">
          Engineering Tomorrow's Software with <span class="text-brand">Integrity & Precision</span>
        </h1>
        <p class="text-slate-300 text-xs sm:text-sm leading-relaxed max-w-xl mx-auto mb-8">
          Founded in 2025 in Dhaka, SoftPolli is a team of software engineers, architects, and product strategists passionate about building dependable technology for ambitious companies.
        </p>
      </div>
    </section>

    <!-- ============ STORY & CULTURE ============ -->
    <section class="py-24 bg-white">
      <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6 grid lg:grid-cols-2 gap-16 items-center">
        <div>
          <p class="text-brand font-bold tracking-[0.2em] text-xs uppercase mb-3 relative inline-block">
            OUR STORY
            <span class="absolute -bottom-1 left-0 w-8 h-[2px] bg-brand"></span>
          </p>
          <h2 class="text-3xl sm:text-4xl font-extrabold text-navy-900 leading-tight mb-6">
            Bridging Business Demands with Modern Engineering
          </h2>
          <div class="space-y-4 text-xs sm:text-sm text-slate-500 leading-relaxed">
            <p>
              SoftPolli was founded with a clear mission: eliminate the disconnect between business requirements and software development. Too many companies struggle with fragile software, unpredictable delays, and vendor lock-in.
            </p>
            <p>
              We took a radically different approach: clean, modular monolithic architecture with full source code ownership, transparent sprint demos, and high-performance engineering standards.
            </p>
            <p>
              Today, our platforms power retail POS networks, transport ticketing portals, educational CRM systems, and enterprise supply chains across Bangladesh and beyond.
            </p>
          </div>

          <div class="grid grid-cols-3 gap-6 pt-8 mt-8 border-t border-slate-100 text-center sm:text-left">
            <div>
              <span class="text-3xl sm:text-4xl font-extrabold text-brand block">11+</span>
              <span class="text-xs text-slate-500 font-medium">Global Clients</span>
            </div>
            <div>
              <span class="text-3xl sm:text-4xl font-extrabold text-navy-900 block">14+</span>
              <span class="text-xs text-slate-500 font-medium">Live Systems</span>
            </div>
            <div>
              <span class="text-3xl sm:text-4xl font-extrabold text-brand block">99%</span>
              <span class="text-xs text-slate-500 font-medium">Uptime Guarantee</span>
            </div>
          </div>
        </div>

        <div class="space-y-6">
          <div class="rounded-3xl overflow-hidden shadow-2xl h-[340px]">
            <img src="/images/happymeeting.jpg" alt="SoftPolli Team Collaboration" class="w-full h-full object-cover" />
          </div>
          <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-brand text-white flex items-center justify-center shrink-0 text-xl">
              <i class="fa-solid fa-handshake"></i>
            </div>
            <div>
              <h4 class="font-bold text-sm text-navy-900">Direct Engineer Collaboration</h4>
              <p class="text-xs text-slate-500">You talk directly to the software engineers building your product, not layers of account reps.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ============ LEADERSHIP TEAM ============ -->
    <section class="py-24 bg-navy-900 text-white">
      <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6">
        <div class="text-center max-w-xl mx-auto mb-16">
          <p class="text-brand font-bold tracking-[0.2em] text-xs uppercase mb-3 relative inline-block">
            LEADERSHIP
            <span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-8 h-[2px] bg-brand"></span>
          </p>
          <h2 class="text-3xl sm:text-4xl font-extrabold text-white">
            The Minds Behind SoftPolli
          </h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          <div
            v-for="member in teamMembers"
            :key="member.name"
            class="bg-slate-800 rounded-2xl overflow-hidden group border border-slate-700/60 flex flex-col justify-between"
          >
            <div class="h-[320px] overflow-hidden">
              <img :src="member.image" :alt="member.name" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
            </div>
            <div class="p-6 bg-navy-950">
              <h4 class="font-bold text-base text-white">{{ member.name }}</h4>
              <p class="text-xs text-slate-400 mt-0.5">{{ member.role }}</p>
              
              <div class="flex items-center gap-2 mt-4 pt-4 border-t border-slate-800 text-slate-400">
                <a v-if="member.social?.facebook" :href="member.social.facebook" target="_blank" class="w-7 h-7 rounded-full bg-slate-800 hover:bg-brand hover:text-white transition grid place-items-center text-xs">
                  <i class="fa-brands fa-facebook-f text-[10px]"></i>
                </a>
                <a v-if="member.social?.linkedin" :href="member.social.linkedin" target="_blank" class="w-7 h-7 rounded-full bg-slate-800 hover:bg-brand hover:text-white transition grid place-items-center text-xs">
                  <i class="fa-brands fa-linkedin-in text-[10px]"></i>
                </a>
                <a v-if="member.social?.website" :href="member.social.website" target="_blank" class="w-7 h-7 rounded-full bg-slate-800 hover:bg-brand hover:text-white transition grid place-items-center text-xs">
                  <i class="fa-solid fa-globe text-[10px]"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ============ CORE VALUES ============ -->
    <section class="py-24 bg-slate-50">
      <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6">
        <div class="text-center max-w-xl mx-auto mb-16">
          <p class="text-brand font-bold tracking-[0.2em] text-xs uppercase mb-3 relative inline-block">
            GUIDING PRINCIPLES
            <span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-8 h-[2px] bg-brand"></span>
          </p>
          <h2 class="text-3xl sm:text-4xl font-extrabold text-navy-900">
            Our Core Values
          </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
            <div class="w-12 h-12 rounded-2xl bg-brand/10 text-brand flex items-center justify-center text-xl mb-6">
              <i class="fa-solid fa-code"></i>
            </div>
            <h3 class="font-bold text-lg text-navy-900 mb-2">Technical Rigor</h3>
            <p class="text-xs text-slate-500 leading-relaxed">
              We never cut corners on database normalization, security patches, or automated testing. Code quality is non-negotiable.
            </p>
          </div>

          <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
            <div class="w-12 h-12 rounded-2xl bg-brand/10 text-brand flex items-center justify-center text-xl mb-6">
              <i class="fa-solid fa-eye"></i>
            </div>
            <h3 class="font-bold text-lg text-navy-900 mb-2">Radical Transparency</h3>
            <p class="text-xs text-slate-500 leading-relaxed">
              No black-box development. You have full visibility into task boards, Git commits, and staging previews at every sprint.
            </p>
          </div>

          <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
            <div class="w-12 h-12 rounded-2xl bg-brand/10 text-brand flex items-center justify-center text-xl mb-6">
              <i class="fa-solid fa-lock-open"></i>
            </div>
            <h3 class="font-bold text-lg text-navy-900 mb-2">Zero Vendor Lock-in</h3>
            <p class="text-xs text-slate-500 leading-relaxed">
              You own 100% of your source code, databases, and digital assets. We build on open-source standards with comprehensive documentation.
            </p>
          </div>
        </div>
      </div>
    </section>
  </MainLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

defineProps({
  teamMembers: Array,
});
</script>
