<template>
  <MainLayout>
    <MetaHead
      title="Smart Software Solutions For Modern Businesses"
      description="SoftPolli delivers world-class software engineering, cloud architecture, and digital transformation systems for modern enterprises."
      image="/images/SP-logo.png"
    />

    <!-- ============ HERO SLIDER ============ -->
    <HeroSlider />

    <!-- ============ OUR PRODUCTS ============ -->
    <section id="products" class="py-24 bg-gradient-to-b from-white via-slate-50/40 to-white relative overflow-hidden border-b border-slate-100">
      <!-- Ambient decorative background -->
      <div class="absolute top-0 right-1/4 w-96 h-96 bg-brand/5 rounded-full blur-3xl pointer-events-none"></div>

      <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6 relative">
        <!-- Section Header -->
        <div class="text-center max-w-2xl mx-auto mb-14">
          <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-brand/10 text-brand text-xs font-bold uppercase tracking-wider mb-4 border border-brand/20">
            <i class="fa-solid fa-cube text-brand"></i> Flagship Platforms & Engines
          </span>
          <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-navy-950 tracking-tight leading-tight">
            Specialized Software Built for <span class="bg-gradient-to-r from-brand to-brand-light bg-clip-text text-transparent">Industry Operations</span>
          </h2>
          <p class="mt-4 text-slate-600 text-sm sm:text-base leading-relaxed">
            Turn-key, battle-tested ERP, CRM, and POS platforms engineered with modular database schemas, offline synchronization, and bank-grade data security.
          </p>
        </div>

        <!-- Products Showcase Component with Category Filter, Search & Specs Modal -->
        <ProductsShowcase :products="products" />
      </div>
    </section>

    <!-- ============ SERVICES SHOWCASE ============ -->
    <section id="services" class="bg-navy-900 text-white py-24 relative overflow-hidden border-b border-slate-800">
      <!-- Ambient light effect -->
      <div class="absolute top-1/2 left-0 -translate-y-1/2 w-96 h-96 bg-brand/10 rounded-full blur-3xl pointer-events-none"></div>

      <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6 relative">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-12">
          <div class="max-w-2xl">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-brand/20 border border-brand/30 text-brand-light text-xs font-bold uppercase tracking-wider mb-4">
              <i class="fa-solid fa-layer-group text-brand"></i> End-to-End Digital Engineering
            </span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight">
              Enterprise Capabilities Engineered for <span class="bg-gradient-to-r from-brand to-brand-light bg-clip-text text-transparent">Scale & Longevity</span>
            </h2>
            <p class="mt-4 text-slate-400 text-xs sm:text-sm leading-relaxed">
              We cover all software, cloud infrastructure, and security disciplines your enterprise needs to automate operations, harden systems, and accelerate customer acquisition.
            </p>
          </div>
          <Link
            href="/services"
            class="inline-flex items-center gap-2 border border-white/20 hover:border-brand hover:text-brand hover:bg-white/5 text-xs font-bold px-6 py-3 rounded-full transition shrink-0"
          >
            <span>Explore All Services</span>
            <i class="fa-solid fa-arrow-right text-[10px]"></i>
          </Link>
        </div>

        <!-- Interactive Services Showcase Component -->
        <ServicesShowcase :services="services" />
      </div>
    </section>

    <!-- ============ FEATURED PROJECTS / PORTFOLIO ============ -->
    <section id="projects" class="py-24 bg-white">
      <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-16">
          <div>
            <p class="text-brand font-bold tracking-[0.2em] text-xs uppercase mb-3 relative inline-block">
              PORTFOLIO SHOWCASE
              <span class="absolute -bottom-1 left-0 w-8 h-[2px] bg-brand"></span>
            </p>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-navy-900 leading-tight">
              Selected Digital Products & Platforms
            </h2>
          </div>
          <Link
            href="/portfolio"
            class="inline-flex items-center gap-2 border border-slate-200 hover:border-brand hover:text-brand text-xs font-bold px-6 py-3 rounded-full transition"
          >
            Explore All Projects <i class="fa-solid fa-arrow-right text-[10px]"></i>
          </Link>
        </div>

        <div class="space-y-16">
          <article
            v-for="(project, index) in projects"
            :key="project.id"
            class="grid md:grid-cols-2 gap-10 items-center border-b border-slate-100 pb-16"
          >
            <div :class="index % 2 === 1 ? 'md:order-2' : ''">
              <span class="stroke-number text-5xl sm:text-6xl font-extrabold block mb-2">{{ project.number }}</span>
              <p class="text-brand text-xs font-bold tracking-wider mb-2 uppercase">{{ project.title }} — {{ project.category }}</p>
              <h3 class="text-2xl sm:text-3xl font-extrabold text-navy-900 leading-snug mb-3">
                {{ project.tagline }}
              </h3>
              <div class="text-slate-500 text-xs sm:text-sm leading-relaxed mb-6 prose prose-xs sm:prose-sm max-w-none prose-slate [&_p]:mb-2 [&_ul]:list-disc [&_ul]:ml-4" v-html="sanitizeHtml(project.description)"></div>
              <div class="flex items-center gap-4">
                <a
                  :href="project.live_url"
                  target="_blank"
                  class="inline-flex items-center gap-2 bg-brand hover:bg-brand-light text-white text-xs font-bold px-5 py-2.5 rounded-full transition shadow-md shadow-brand/20"
                >
                  Live Preview <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                </a>
                <span class="text-xs text-slate-400 font-medium">
                  <i class="fa-solid fa-bolt text-brand mr-1"></i> {{ project.metrics }}
                </span>
              </div>
            </div>

            <div :class="index % 2 === 1 ? 'md:order-1' : ''" class="rounded-3xl overflow-hidden shadow-xl h-[280px] sm:h-[340px] border border-slate-100 group">
              <img
                :src="project.image"
                :alt="project.title"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
              />
            </div>
          </article>
        </div>
      </div>
    </section>

    <!-- ============ REDESIGNED ABOUT US & IMPACT ECOSYSTEM ============ -->
    <section id="about" class="py-24 bg-white relative overflow-hidden">
      <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6">
        <div class="grid lg:grid-cols-12 gap-12 lg:gap-16 items-center">
          <!-- Left: Dual-Image Layered Composition (5 cols on lg, 6 cols on xl) -->
          <div class="lg:col-span-5 xl:col-span-6 relative">
            <div class="relative mx-auto max-w-md lg:max-w-none">
              <!-- Primary Main Photo -->
              <div class="rounded-3xl overflow-hidden shadow-2xl border border-slate-100 h-[380px] sm:h-[440px] relative group">
                <img
                  src="/images/happymeeting.jpg"
                  alt="SoftPolli Engineering Team Collaboration"
                  class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-navy-950/60 via-transparent to-transparent"></div>
              </div>

              <!-- Secondary Floating Team Accent Card -->
              <div class="hidden sm:block absolute -bottom-8 -right-6 w-56 h-48 rounded-2xl overflow-hidden shadow-2xl border-4 border-white dark:border-slate-800 z-10 group">
                <img
                  src="/images/about-team.png"
                  alt="SoftPolli Office Engineers"
                  class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                />
              </div>

              <!-- Floating Glassmorphic Milestone Pill -->
              <div class="absolute -top-6 -left-4 sm:-left-6 bg-navy-950/90 backdrop-blur-md text-white p-4 sm:p-5 rounded-2xl shadow-2xl border border-white/10 z-20 flex items-center gap-3.5 max-w-[280px]">
                <div class="w-10 h-10 rounded-xl bg-brand text-white grid place-items-center text-lg shrink-0 shadow-md shadow-brand/30">
                  <i class="fa-solid fa-code-commit"></i>
                </div>
                <div>
                  <p class="font-bold text-xs text-white">Full IP & Code Ownership</p>
                  <p class="text-[10px] text-slate-300 mt-0.5">100% Repository Handover</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Right: Story, Impact Metrics & Tech Stack (7 cols on lg, 6 cols on xl) -->
          <div class="lg:col-span-7 xl:col-span-6">
            <p class="text-brand font-bold tracking-[0.2em] text-xs uppercase mb-3 relative inline-block">
              ABOUT SOFTPOLLI
              <span class="absolute -bottom-1 left-0 w-8 h-[2px] bg-brand"></span>
            </p>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-navy-900 leading-tight mb-5">
              Your Dedicated Software Engineering & Architecture Partner
            </h2>
            <p class="text-slate-600 text-sm leading-relaxed mb-4">
              Founded in Dhaka in 2025, SoftPolli was created with a clear purpose: to engineer dependable, high-performance software systems that eliminate operational bottlenecks and drive sustained business growth.
            </p>
            <p class="text-slate-500 text-xs sm:text-sm leading-relaxed mb-8">
              We partner directly with founders and enterprise leaders to architect custom multi-branch ERPs, high-conversion web platforms, and automated workflow engines tailored specifically to their operational scale.
            </p>

            <!-- 4 Modern Metric Cards Grid -->
            <div class="grid grid-cols-2 gap-4 mb-8">
              <div class="p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-brand/30 transition group">
                <span class="text-2xl sm:text-3xl font-extrabold text-brand block mb-1">15+</span>
                <p class="text-xs font-bold text-navy-900">Enterprise Systems Built</p>
                <p class="text-[11px] text-slate-500 mt-0.5">Custom ERPs, Web & POS</p>
              </div>

              <div class="p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-brand/30 transition group">
                <span class="text-2xl sm:text-3xl font-extrabold text-navy-900 block mb-1">99.99%</span>
                <p class="text-xs font-bold text-navy-900">Uptime SLA Standard</p>
                <p class="text-[11px] text-slate-500 mt-0.5">Fault-tolerant infrastructure</p>
              </div>

              <div class="p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-brand/30 transition group">
                <span class="text-2xl sm:text-3xl font-extrabold text-navy-900 block mb-1">2+ Yrs</span>
                <p class="text-xs font-bold text-navy-900">Engineering Excellence</p>
                <p class="text-[11px] text-slate-500 mt-0.5">Located in Shyamoli, Dhaka</p>
              </div>

              <div class="p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-brand/30 transition group">
                <span class="text-2xl sm:text-3xl font-extrabold text-emerald-600 block mb-1">&lt;15m</span>
                <p class="text-xs font-bold text-navy-900">Direct Support SLA</p>
                <p class="text-[11px] text-slate-500 mt-0.5">Senior engineer channel</p>
              </div>
            </div>

            <!-- Tech Stack Pill Row -->
            <div class="mb-8 pt-4 border-t border-slate-100">
              <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider block mb-2.5">
                Core Engineering Stack:
              </span>
              <div class="flex flex-wrap gap-2 text-xs">
                <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 font-semibold text-[11px]">Laravel 12</span>
                <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 font-semibold text-[11px]">Vue 3</span>
                <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 font-semibold text-[11px]">Tailwind CSS</span>
                <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 font-semibold text-[11px]">MySQL & Postgres</span>
                <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 font-semibold text-[11px]">Redis</span>
                <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 font-semibold text-[11px]">Docker & AWS</span>
              </div>
            </div>

            <!-- CTA Actions -->
            <div class="flex flex-wrap items-center gap-4">
              <Link
                href="/about"
                class="inline-flex items-center gap-2 bg-navy-900 hover:bg-navy-800 text-white text-xs font-bold px-7 py-3.5 rounded-full transition shadow-md"
              >
                Our Story & Leadership <i class="fa-solid fa-arrow-right text-xs"></i>
              </Link>
              <Link
                href="/services"
                class="inline-flex items-center gap-2 border border-slate-200 hover:border-brand hover:text-brand text-xs font-semibold px-6 py-3.5 rounded-full transition"
              >
                Explore Services
              </Link>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ============ WHY CHOOSE US — ENTERPRISE CAPABILITIES BENTO GRID ============ -->
    <section class="py-24 bg-slate-50 border-y border-slate-200/80">
      <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6">
        <!-- Section Header -->
        <div class="text-center max-w-2xl mx-auto mb-16">
          <p class="text-brand font-bold tracking-[0.2em] text-xs uppercase mb-3 relative inline-block">
            WHY CHOOSE SOFTPOLLI
            <span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-8 h-[2px] bg-brand"></span>
          </p>
          <h2 class="text-3xl sm:text-4xl font-extrabold text-navy-900 leading-tight">
            Engineered for Precision, Built for Uncompromising Scale
          </h2>
          <p class="text-slate-500 text-xs sm:text-sm leading-relaxed mt-4">
            We don't just deliver software — we build scalable digital infrastructure, automate mission-critical workflows, and guarantee complete source code ownership.
          </p>
        </div>

        <!-- Bento Grid (12-Columns) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-6 mb-12">
          <!-- Bento Card 1: Enterprise Architecture (7 cols) -->
          <div class="lg:col-span-7 bg-navy-950 text-white rounded-3xl p-8 sm:p-10 border border-slate-800 shadow-xl relative overflow-hidden flex flex-col justify-between group">
            <div class="absolute -right-12 -top-12 w-64 h-64 bg-brand/10 rounded-full blur-3xl pointer-events-none group-hover:bg-brand/20 transition-all duration-700"></div>

            <div class="relative z-10">
              <div class="flex items-center justify-between gap-4 mb-6">
                <div class="w-12 h-12 rounded-2xl bg-brand/20 text-brand flex items-center justify-center text-xl shadow-inner border border-brand/30">
                  <i class="fa-solid fa-server"></i>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-[11px] font-bold">
                  <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                  99.99% Uptime SLA
                </span>
              </div>

              <h3 class="text-xl sm:text-2xl font-extrabold text-white mb-3">
                High-Availability Architecture & Scalable ERP
              </h3>
              <p class="text-slate-300 text-xs sm:text-sm leading-relaxed mb-6 max-w-xl">
                We engineer fault-tolerant, high-concurrency systems using modular services, isolated multi-tenant databases, and distributed caching capable of processing millions of transactions without bottlenecks.
              </p>

              <!-- Architecture Badges -->
              <div class="flex flex-wrap gap-2 text-xs">
                <span class="px-3 py-1.5 rounded-xl bg-white/5 border border-white/10 text-slate-300 font-medium">
                  <i class="fa-solid fa-database text-brand mr-1"></i> MySQL & PostgreSQL Clustering
                </span>
                <span class="px-3 py-1.5 rounded-xl bg-white/5 border border-white/10 text-slate-300 font-medium">
                  <i class="fa-solid fa-bolt text-brand mr-1"></i> In-Memory Redis Cache
                </span>
                <span class="px-3 py-1.5 rounded-xl bg-white/5 border border-white/10 text-slate-300 font-medium">
                  <i class="fa-solid fa-box-archive text-brand mr-1"></i> Encrypted Automated Backups
                </span>
              </div>
            </div>

            <div class="relative z-10 mt-8 pt-6 border-t border-slate-800/80 flex items-center justify-between text-xs text-slate-400">
              <span>Full Source Code Handover</span>
              <span class="text-brand font-bold flex items-center gap-1">Zero Vendor Lock-In <i class="fa-solid fa-check text-[10px]"></i></span>
            </div>
          </div>

          <!-- Bento Card 2: Agile Sprints & Fast Demos (5 cols) -->
          <div class="lg:col-span-5 bg-white rounded-3xl p-8 sm:p-10 border border-slate-200/80 shadow-md hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
            <div>
              <div class="flex items-center justify-between gap-4 mb-6">
                <div class="w-12 h-12 rounded-2xl bg-orange-500/10 text-brand flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                  <i class="fa-solid fa-rocket"></i>
                </div>
                <span class="text-xs font-mono font-extrabold text-navy-900 bg-slate-100 px-3 py-1 rounded-full border border-slate-200">
                  Sprint Cycle: 2 Weeks
                </span>
              </div>

              <h3 class="text-xl font-extrabold text-navy-900 mb-2">
                Agile Sprints with Weekly Live Demos
              </h3>
              <p class="text-slate-500 text-xs sm:text-sm leading-relaxed mb-6">
                No guessing games. You test your features every week on private staging environments, provide instant feedback, and iterate before production rollout.
              </p>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-2 text-xs">
              <div class="flex items-center justify-between text-slate-700 font-semibold">
                <span>Milestone Transparency</span>
                <span class="text-brand font-bold">100% Trackable</span>
              </div>
              <div class="w-full bg-slate-200 rounded-full h-1.5 overflow-hidden">
                <div class="bg-brand h-1.5 rounded-full" style="width: 100%"></div>
              </div>
              <p class="text-[11px] text-slate-400">Weekly sprint review & demo call included</p>
            </div>
          </div>

          <!-- Bento Card 3: Enterprise Security (4 cols) -->
          <div class="lg:col-span-4 bg-white rounded-3xl p-8 border border-slate-200/80 shadow-md hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
            <div>
              <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center text-xl mb-6 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-shield-halved"></i>
              </div>
              <h3 class="text-lg font-extrabold text-navy-900 mb-2">
                Military-Grade Hardening
              </h3>
              <p class="text-slate-500 text-xs leading-relaxed mb-6">
                Protected against OWASP Top 10 vulnerabilities with CSRF shielding, rate limiting, and parameter validation.
              </p>
            </div>
            <ul class="space-y-2 text-xs text-slate-600 border-t border-slate-100 pt-4">
              <li class="flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-500 text-[10px]"></i>
                <span>SSL/TLS 1.3 Transport Encryption</span>
              </li>
              <li class="flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-500 text-[10px]"></i>
                <span>Role-Based Access Control (RBAC)</span>
              </li>
              <li class="flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-500 text-[10px]"></i>
                <span>Immutable Audit Trail Logs</span>
              </li>
            </ul>
          </div>

          <!-- Bento Card 4: Offline-First & Realtime Sync (4 cols) -->
          <div class="lg:col-span-4 bg-white rounded-3xl p-8 border border-slate-200/80 shadow-md hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
            <div>
              <div class="w-12 h-12 rounded-2xl bg-sky-500/10 text-sky-600 flex items-center justify-center text-xl mb-6 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-arrows-rotate"></i>
              </div>
              <h3 class="text-lg font-extrabold text-navy-900 mb-2">
                Offline-First & Smart Sync
              </h3>
              <p class="text-slate-500 text-xs leading-relaxed mb-6">
                Keep sales terminals and branch counters operational during internet outages with automatic conflict resolution upon reconnection.
              </p>
            </div>
            <ul class="space-y-2 text-xs text-slate-600 border-t border-slate-100 pt-4">
              <li class="flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-sky-500 text-[10px]"></i>
                <span>Local Storage Resiliency</span>
              </li>
              <li class="flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-sky-500 text-[10px]"></i>
                <span>Instant Multi-Branch Reconciliation</span>
              </li>
              <li class="flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-sky-500 text-[10px]"></i>
                <span>Zero Sales Downtime</span>
              </li>
            </ul>
          </div>

          <!-- Bento Card 5: Direct Senior Engineering Access (4 cols) -->
          <div class="lg:col-span-4 bg-white rounded-3xl p-8 border border-slate-200/80 shadow-md hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
            <div>
              <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 text-indigo-600 flex items-center justify-center text-xl mb-6 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-headset"></i>
              </div>
              <h3 class="text-lg font-extrabold text-navy-900 mb-2">
                Direct Architect Access
              </h3>
              <p class="text-slate-500 text-xs leading-relaxed mb-6">
                Direct WhatsApp, Slack, and phone channel to senior system architects who know your codebase inside and out.
              </p>
            </div>
            <ul class="space-y-2 text-xs text-slate-600 border-t border-slate-100 pt-4">
              <li class="flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-indigo-500 text-[10px]"></i>
                <span>Dedicated Tech Lead</span>
              </li>
              <li class="flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-indigo-500 text-[10px]"></i>
                <span>Rapid Incident Escalation</span>
              </li>
              <li class="flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-indigo-500 text-[10px]"></i>
                <span>Post-Launch Maintenance Support</span>
              </li>
            </ul>
          </div>
        </div>

        <!-- Bottom Action Strip -->
        <div class="p-8 rounded-3xl bg-white border border-slate-200/80 shadow-md flex flex-col md:flex-row items-center justify-between gap-6">
          <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-brand/10 text-brand grid place-items-center text-xl shrink-0">
              <i class="fa-solid fa-handshake"></i>
            </div>
            <div>
              <h4 class="font-extrabold text-base text-navy-900">Ready to build software tailored to your workflow?</h4>
              <p class="text-xs text-slate-500 mt-0.5">Book a free 30-minute system architecture session with our engineering leads.</p>
            </div>
          </div>
          <div class="flex flex-wrap items-center gap-3">
            <Link
              href="/contact"
              class="inline-flex items-center gap-2 bg-brand hover:bg-brand-light text-white text-xs font-bold px-7 py-3.5 rounded-full transition shadow-lg shadow-brand/20"
            >
              Start Consultation <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </Link>
            <Link
              href="/portfolio"
              class="inline-flex items-center gap-2 border border-slate-200 hover:border-brand hover:text-brand text-xs font-semibold px-6 py-3.5 rounded-full transition"
            >
              View Case Studies
            </Link>
          </div>
        </div>
      </div>
    </section>

    <!-- ============ TEAM MEMBERS SLIDER ============ -->
    <section class="bg-navy-900 text-white py-24">
      <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6">
        <TeamSlider :team-members="teamMembers" />
      </div>
    </section>

    <!-- ============ TESTIMONIALS & CLIENT SUCCESS ============ -->
    <section class="py-24 bg-gradient-to-b from-white via-slate-50/50 to-white border-b border-slate-100 relative overflow-hidden">
      <!-- Background Grid Accent -->
      <div class="absolute inset-0 bg-[linear-gradient(to_right,#00000008_1px,transparent_1px),linear-gradient(to_bottom,#00000008_1px,transparent_1px)] bg-[size:32px_32px] pointer-events-none opacity-60"></div>

      <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6 relative">
        <!-- Section Header -->
        <div class="max-w-2xl mx-auto text-center mb-14">
          <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-brand/10 text-brand text-xs font-bold uppercase tracking-wider mb-4 border border-brand/20">
            <i class="fa-solid fa-award text-amber-500"></i> Client Endorsements
          </span>
          <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-navy-950 tracking-tight leading-tight">
            Trusted by Leaders <span class="bg-gradient-to-r from-brand to-brand-light bg-clip-text text-transparent">Powering Digital Scale</span>
          </h2>
          <p class="mt-4 text-slate-600 text-sm sm:text-base leading-relaxed">
            Real feedback from visionary founders, operational directors, and enterprise executives who rely on SoftPolli to engineer and maintain mission-critical software.
          </p>
        </div>

        <!-- Trust Stats Proof Strip -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12">
          <div class="bg-white/90 backdrop-blur-sm rounded-2xl p-5 border border-slate-200/80 shadow-sm text-center">
            <div class="flex items-center justify-center text-amber-400 gap-1 text-sm mb-1">
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
            </div>
            <div class="text-2xl font-black text-navy-950">4.9 / 5.0</div>
            <div class="text-xs text-slate-500 font-medium mt-0.5">Verified Client Rating</div>
          </div>

          <div class="bg-white/90 backdrop-blur-sm rounded-2xl p-5 border border-slate-200/80 shadow-sm text-center">
            <div class="text-brand text-sm mb-1"><i class="fa-solid fa-clock-rotate-left"></i></div>
            <div class="text-2xl font-black text-navy-950">100%</div>
            <div class="text-xs text-slate-500 font-medium mt-0.5">On-Time Sprint Delivery</div>
          </div>

          <div class="bg-white/90 backdrop-blur-sm rounded-2xl p-5 border border-slate-200/80 shadow-sm text-center">
            <div class="text-emerald-500 text-sm mb-1"><i class="fa-solid fa-server"></i></div>
            <div class="text-2xl font-black text-navy-950">99.99%</div>
            <div class="text-xs text-slate-500 font-medium mt-0.5">Cloud System Uptime</div>
          </div>

          <div class="bg-white/90 backdrop-blur-sm rounded-2xl p-5 border border-slate-200/80 shadow-sm text-center">
            <div class="text-purple-600 text-sm mb-1"><i class="fa-solid fa-headset"></i></div>
            <div class="text-2xl font-black text-navy-950">&lt; 15 Min</div>
            <div class="text-xs text-slate-500 font-medium mt-0.5">Average Critical SLA</div>
          </div>
        </div>

        <!-- Main Testimonial Spotlight Component -->
        <TestimonialDeck :testimonials="testimonials" />

      </div>
    </section>

    <!-- ============ REDESIGNED FAQ SECTION ============ -->
    <FaqSection :faqs="faqs" />

    <!-- ============ GET IN TOUCH & ARCHITECTURE CONSULTATION ============ -->
    <section id="contact" class="bg-navy-950 text-white relative overflow-hidden py-24 border-t border-slate-800">
      <!-- Ambient light effect -->
      <div class="absolute -top-32 right-0 w-[500px] h-[500px] bg-brand/10 rounded-full blur-3xl pointer-events-none"></div>
      <div class="absolute -bottom-32 left-0 w-[450px] h-[450px] bg-emerald-500/5 rounded-full blur-3xl pointer-events-none"></div>

      <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6 relative z-10">
        <!-- Section Header -->
        <div class="text-center max-w-2xl mx-auto mb-16">
          <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-brand/20 border border-brand/30 text-brand-light text-xs font-bold uppercase tracking-wider mb-4">
            <i class="fa-solid fa-headset text-brand"></i> Direct Engineering Consultation
          </span>
          <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight">
            Let's Engineer Your Next <span class="bg-gradient-to-r from-brand to-brand-light bg-clip-text text-transparent">Digital Milestone</span>
          </h2>
          <p class="mt-4 text-slate-400 text-xs sm:text-sm leading-relaxed">
            Whether you need a custom enterprise ERP, automated retail POS, high-performance web platform, or a complete DevSecOps infrastructure audit — connect directly with our engineering leadership.
          </p>
        </div>

        <div class="grid lg:grid-cols-12 gap-10 items-stretch">
          <!-- Left: Quick Contact Form (7 cols) -->
          <div class="lg:col-span-7">
            <QuickContactForm />
          </div>

          <!-- Right: Interactive Contact & Direct Communication Deck (5 cols) -->
          <div class="lg:col-span-5 flex flex-col justify-between space-y-6">
            <!-- Office Visual Card -->
            <div class="relative rounded-3xl overflow-hidden border border-slate-800 bg-navy-900 group shadow-xl">
              <div class="h-56 relative overflow-hidden">
                <img
                  src="/images/contact-team2.jpg"
                  alt="SoftPolli Dhaka Office"
                  class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-navy-950 via-navy-950/50 to-transparent"></div>

                <!-- Live Status Pill -->
                <div class="absolute top-4 left-4">
                  <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-navy-950/80 backdrop-blur-md text-emerald-400 border border-emerald-500/30 text-[11px] font-bold">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Team On Duty &bull; Rapid Response
                  </span>
                </div>

                <div class="absolute bottom-4 left-5 right-5 text-white">
                  <span class="text-[10px] font-extrabold uppercase tracking-widest text-brand block mb-0.5">
                    Dhaka Engineering Office
                  </span>
                  <h4 class="font-bold text-lg text-white">SoftPolli Engineering Office</h4>
                </div>
              </div>

              <!-- Address & Navigation details -->
              <div class="p-6 space-y-3 text-xs bg-navy-900/95 border-t border-slate-800">
                <div class="flex items-start gap-3">
                  <i class="fa-solid fa-location-dot text-brand text-sm mt-0.5 shrink-0"></i>
                  <div>
                    <p class="text-slate-300 font-medium leading-relaxed">
                      {{ settings.contact_address || '2B/4 Ring Road, Shyamoli, Dhaka 1207, Bangladesh' }}
                    </p>
                    <a
                      :href="settings.google_maps_url || 'https://maps.google.com'"
                      target="_blank"
                      rel="noopener noreferrer"
                      class="inline-flex items-center gap-1.5 text-brand text-[11px] font-bold hover:underline mt-1"
                    >
                      <span>Open in Google Maps</span>
                      <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                    </a>
                  </div>
                </div>

                <div class="flex items-center gap-3 pt-3 border-t border-slate-800/80 text-slate-400">
                  <i class="fa-regular fa-clock text-brand text-sm shrink-0"></i>
                  <span>{{ settings.business_hours || 'Sat to Thursday: 8:00 AM – 7:00 PM' }}</span>
                </div>
              </div>
            </div>

            <!-- Direct Fast-Track Communication Channels -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <!-- Hotline Call -->
              <a
                :href="`tel:${cleanPhone(settings.contact_phone || '+880 1700-000000')}`"
                class="p-5 rounded-2xl bg-navy-900/80 border border-slate-800 hover:border-brand/40 transition-all duration-300 hover:-translate-y-1 group flex flex-col justify-between"
              >
                <div>
                  <div class="w-10 h-10 rounded-xl bg-brand/10 text-brand group-hover:bg-brand group-hover:text-white transition flex items-center justify-center text-sm mb-3">
                    <i class="fa-solid fa-phone"></i>
                  </div>
                  <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Direct Hotline</span>
                  <h5 class="text-sm font-bold text-white mt-1 group-hover:text-brand transition-colors">
                    {{ settings.contact_phone || '+880 1700-000000' }}
                  </h5>
                </div>
                <span class="text-[11px] text-brand font-semibold flex items-center gap-1 mt-3">
                  <span>Call Now</span>
                  <i class="fa-solid fa-arrow-right text-[9px]"></i>
                </span>
              </a>

              <!-- WhatsApp Chat -->
              <a
                :href="`https://wa.me/${cleanPhone(settings.whatsapp_phone_number || settings.contact_phone || '8801700000000')}?text=Hello%20SoftPolli%2C%20I%20would%20like%20to%20discuss%20a%20software%20project.`"
                target="_blank"
                rel="noopener noreferrer"
                class="p-5 rounded-2xl bg-navy-900/80 border border-slate-800 hover:border-emerald-500/40 transition-all duration-300 hover:-translate-y-1 group flex flex-col justify-between"
              >
                <div>
                  <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-400 group-hover:bg-emerald-500 group-hover:text-white transition flex items-center justify-center text-sm mb-3">
                    <i class="fa-brands fa-whatsapp"></i>
                  </div>
                  <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">WhatsApp Fast Track</span>
                  <h5 class="text-sm font-bold text-white mt-1 group-hover:text-emerald-400 transition-colors">
                    Instant Messaging
                  </h5>
                </div>
                <span class="text-[11px] text-emerald-400 font-semibold flex items-center gap-1 mt-3">
                  <span>Chat With Architect</span>
                  <i class="fa-solid fa-arrow-right text-[9px]"></i>
                </span>
              </a>
            </div>

            <!-- Email & Direct Correspondence -->
            <div class="p-5 rounded-2xl bg-navy-900/60 border border-slate-800 text-xs flex items-center justify-between gap-4">
              <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white/5 text-brand flex items-center justify-center text-xs shrink-0">
                  <i class="fa-solid fa-envelope"></i>
                </div>
                <div>
                  <span class="text-[10px] uppercase font-bold text-slate-400 block">Corporate Email</span>
                  <a :href="`mailto:${settings.contact_email || 'info@softpolli.com'}`" class="text-white hover:text-brand font-semibold transition">
                    {{ settings.contact_email || 'info@softpolli.com' }}
                  </a>
                </div>
              </div>
              <div class="text-right hidden sm:block">
                <span class="text-[10px] uppercase font-bold text-slate-400 block">Technical Support</span>
                <a :href="`mailto:${settings.support_email || 'support@softpolli.com'}`" class="text-slate-300 hover:text-brand font-medium transition">
                  {{ settings.support_email || 'support@softpolli.com' }}
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </MainLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import MetaHead from '@/Components/MetaHead.vue';
import HeroSlider from '@/Components/HeroSlider.vue';
import ProductsShowcase from '@/Components/ProductsShowcase.vue';
import ServicesShowcase from '@/Components/ServicesShowcase.vue';
import QuickContactForm from '@/Components/QuickContactForm.vue';
import TeamSlider from '@/Components/TeamSlider.vue';
import TestimonialDeck from '@/Components/TestimonialDeck.vue';
import FaqSection from '@/Components/FaqSection.vue';
import { sanitizeHtml } from '@/Utils/sanitize';

defineProps({
  products: Array,
  services: Array,
  projects: Array,
  teamMembers: Array,
  testimonials: Array,
  faqs: Array,
});

const page = usePage();
const settings = computed(() => page.props.settings || {});

function cleanPhone(phone) {
  if (!phone) return '';
  return phone.replace(/[^0-9+]/g, '');
}
</script>
