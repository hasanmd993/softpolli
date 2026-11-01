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
    <section id="products" class="py-24 bg-white">
      <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6">
        <div class="text-center max-w-xl mx-auto mb-16">
          <p class="text-brand font-bold tracking-[0.2em] text-xs uppercase mb-3 relative inline-block">
            OUR PRODUCTS
            <span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-8 h-[2px] bg-brand"></span>
          </p>
          <h2 class="text-3xl sm:text-4xl font-extrabold text-navy-900 leading-tight">
            Specialized Software Built for Industry Operations
          </h2>
        </div>

        <!-- 8 Product Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          <div
            v-for="product in products"
            :key="product.id"
            class="group rounded-3xl border border-slate-100 p-7 hover:border-brand/40 hover:shadow-xl transition-all duration-300 flex flex-col justify-between"
            :style="{ backgroundColor: product.bg }"
          >
            <div>
              <div class="w-12 h-12 rounded-2xl bg-brand/10 text-brand flex items-center justify-center text-lg mb-5 group-hover:bg-brand group-hover:text-white transition">
                <i :class="['fa-solid', product.icon]"></i>
              </div>
              <h3 class="font-bold text-xl text-navy-900 mb-2">{{ product.title }}</h3>
              <div class="text-xs text-slate-600 leading-relaxed mb-6 prose prose-xs max-w-none prose-slate [&_p]:mb-1 [&_ul]:list-disc [&_ul]:ml-4" v-html="sanitizeHtml(product.description)"></div>
            </div>
            <Link
              href="/contact"
              class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand group-hover:translate-x-1 transition-transform"
            >
              Request Demo <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </Link>
          </div>
        </div>
      </div>
    </section>

    <!-- ============ SERVICES CAROUSEL ============ -->
    <section id="services" class="bg-navy-900 text-white py-24">
      <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-12">
          <div>
            <p class="text-brand font-bold tracking-[0.2em] text-xs uppercase mb-3 relative inline-block">
              OUR SERVICES
              <span class="absolute -bottom-1 left-0 w-8 h-[2px] bg-brand"></span>
            </p>
            <h2 class="text-3xl sm:text-4xl font-extrabold leading-tight max-w-xl">
              We cover all software capabilities your business needs to grow.
            </h2>
          </div>
          <div class="flex items-center gap-3">
            <button
              @click="scrollCarousel(-400)"
              class="grid place-items-center w-12 h-12 rounded-full border border-white/20 hover:bg-white/10 transition"
              aria-label="Previous service"
            >
              <i class="fa-solid fa-arrow-left"></i>
            </button>
            <button
              @click="scrollCarousel(400)"
              class="grid place-items-center w-12 h-12 rounded-full bg-brand hover:bg-brand-light transition shadow-md shadow-brand/25"
              aria-label="Next service"
            >
              <i class="fa-solid fa-arrow-right"></i>
            </button>
          </div>
        </div>

        <!-- Carousel Track -->
        <div
          ref="servicesCarousel"
          class="flex gap-6 overflow-x-auto pb-4 snap-x scroll-smooth [scrollbar-width:none] [-ms-overflow-style:none]"
        >
          <article
            v-for="(service, i) in services"
            :key="service.id"
            class="snap-start shrink-0 w-[85%] sm:w-[380px] relative rounded-3xl overflow-hidden group h-[380px]"
          >
            <img :src="service.image" :alt="service.title" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
            <div class="absolute inset-0 bg-gradient-to-t from-navy-950 via-navy-950/40 to-transparent"></div>
            
            <div class="absolute bottom-6 left-6 right-6 flex items-end justify-between">
              <div>
                <span class="text-3xl font-extrabold text-white/40 block">0{{ i + 1 }}.</span>
                <span class="text-[10px] font-bold text-brand uppercase tracking-wider">{{ service.tag }}</span>
                <p class="mt-1 font-bold text-base text-white leading-snug">{{ service.title }}</p>
              </div>
              <Link
                href="/services"
                class="grid place-items-center w-11 h-11 rounded-full bg-white/10 hover:bg-brand text-white shrink-0 transition"
              >
                <i class="fa-solid fa-arrow-up rotate-45 text-sm"></i>
              </Link>
            </div>
          </article>
        </div>
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

    <!-- ============ ABOUT & METRICS ============ -->
    <section id="about" class="py-24 bg-slate-50 border-y border-slate-100">
      <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6 grid lg:grid-cols-2 xl:grid-cols-3 gap-12 items-center">
        <div>
          <p class="text-brand font-bold tracking-[0.2em] text-xs uppercase mb-3 relative inline-block">
            ABOUT US
            <span class="absolute -bottom-1 left-0 w-8 h-[2px] bg-brand"></span>
          </p>
          <h2 class="text-3xl sm:text-4xl font-extrabold leading-tight mb-5 text-navy-900">
            Transforming Ambition into Scalable Digital Reality
          </h2>
          <p class="text-slate-500 text-sm leading-relaxed mb-8">
            We build reliable, tailored software solutions to help businesses streamline daily operations and achieve continuous growth. From custom multi-branch ERP systems to enterprise web portals, we engineer technology built around your exact business goals.
          </p>
          <Link
            href="/about"
            class="inline-flex items-center gap-2 bg-navy-900 hover:bg-navy-800 text-white text-xs font-bold px-7 py-4 rounded-full transition shadow-md"
          >
            Our Story & Values <i class="fa-solid fa-arrow-right text-xs"></i>
          </Link>
        </div>

        <div class="rounded-3xl overflow-hidden shadow-xl h-[360px]">
          <img src="/images/happymeeting.jpg" alt="SoftPolli Engineering Team" class="w-full h-full object-cover" />
        </div>

        <!-- Metric Badges -->
        <div class="lg:col-span-2 xl:col-span-1 flex flex-col justify-between divide-y divide-slate-200">
          <div class="flex items-center gap-4 py-6">
            <span class="grid place-items-center w-12 h-12 rounded-2xl bg-brand/10 text-brand text-lg"><i class="fa-solid fa-users"></i></span>
            <div>
              <p class="text-2xl font-extrabold text-navy-900">11+</p>
              <p class="text-xs text-slate-500">Satisfied clients across the globe</p>
            </div>
          </div>
          <div class="flex items-center gap-4 py-6">
            <span class="grid place-items-center w-12 h-12 rounded-2xl bg-brand/10 text-brand text-lg"><i class="fa-solid fa-gear"></i></span>
            <div>
              <p class="text-2xl font-extrabold text-navy-900">14+</p>
              <p class="text-xs text-slate-500">Completed enterprise projects</p>
            </div>
          </div>
          <div class="flex items-center gap-4 py-6">
            <span class="grid place-items-center w-12 h-12 rounded-2xl bg-brand/10 text-brand text-lg"><i class="fa-solid fa-award"></i></span>
            <div>
              <p class="text-2xl font-extrabold text-navy-900">2+</p>
              <p class="text-xs text-slate-500">Years of continuous engineering excellence</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ============ WHY CHOOSE US & CAPABILITY BARS ============ -->
    <section class="py-24 bg-white">
      <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6 grid lg:grid-cols-2 gap-16 items-center">
        <!-- Image Stack -->
        <div class="relative flex items-center justify-center min-h-[340px] sm:min-h-[400px] overflow-hidden py-4">
          <div class="w-40 sm:w-56 h-56 sm:h-80 rounded-3xl overflow-hidden shadow-lg opacity-40 -rotate-6 absolute left-0 sm:left-6">
            <img src="/images/skills-3.jpg" alt="Engineering" class="w-full h-full object-cover" />
          </div>
          <div class="w-40 sm:w-56 h-56 sm:h-80 rounded-3xl overflow-hidden shadow-xl opacity-75 -rotate-3 absolute left-6 sm:left-20">
            <img src="/images/skills-2.jpg" alt="Meeting" class="w-full h-full object-cover" />
          </div>
          <div class="relative z-10 w-48 sm:w-64 h-64 sm:h-96 rounded-3xl overflow-hidden shadow-2xl ml-8 sm:ml-28">
            <img src="/images/skills-1.jpg" alt="Lead Consultant" class="w-full h-full object-cover" />
            <div class="absolute inset-0 bg-gradient-to-t from-navy-900/90 via-navy-900/30 to-transparent"></div>
            <div class="absolute bottom-6 left-6 right-6 text-white">
              <span class="text-xl font-extrabold text-brand block">01.</span>
              <h4 class="font-bold text-base mt-0.5">Agile Sprint Delivery</h4>
              <p class="text-[11px] text-slate-300 mt-1 leading-snug">
                Transparent weekly demos and milestones guarantee rapid time-to-market.
              </p>
            </div>
          </div>
        </div>

        <!-- Capability Metrics -->
        <div>
          <p class="text-brand font-bold tracking-[0.2em] text-xs uppercase mb-3 relative inline-block">
            WHY CHOOSE US
            <span class="absolute -bottom-1 left-0 w-8 h-[2px] bg-brand"></span>
          </p>
          <h2 class="text-3xl sm:text-4xl font-extrabold text-navy-900 leading-tight mb-4">
            Driven by Technical Precision and Measurable Results
          </h2>
          <p class="text-slate-500 text-xs sm:text-sm leading-relaxed mb-8">
            Founded in 2025 by a dedicated team of software engineers, we combine technical depth with business acumen. We build scalable ERP systems, custom web applications, and smart automation tools designed for longevity.
          </p>

          <div class="space-y-6 max-w-lg mb-8">
            <div>
              <div class="flex justify-between text-xs font-bold text-navy-900 mb-2">
                <span>Custom Software & ERP Development</span>
                <span>99%</span>
              </div>
              <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                <div class="bg-brand h-2.5 rounded-full" style="width: 99%"></div>
              </div>
            </div>
            <div>
              <div class="flex justify-between text-xs font-bold text-navy-900 mb-2">
                <span>Web Application Architecture</span>
                <span>92%</span>
              </div>
              <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                <div class="bg-brand h-2.5 rounded-full" style="width: 92%"></div>
              </div>
            </div>
            <div>
              <div class="flex justify-between text-xs font-bold text-navy-900 mb-2">
                <span>System Automation & Offline Sync</span>
                <span>89%</span>
              </div>
              <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                <div class="bg-brand h-2.5 rounded-full" style="width: 89%"></div>
              </div>
            </div>
          </div>

          <Link href="/contact" class="inline-flex items-center gap-2 bg-navy-900 hover:bg-navy-800 text-white text-xs font-bold px-7 py-4 rounded-full transition shadow-md">
            Request Consultation <i class="fa-solid fa-arrow-right text-[10px]"></i>
          </Link>
        </div>
      </div>
    </section>

    <!-- ============ TEAM MEMBERS SLIDER ============ -->
    <section class="bg-navy-900 text-white py-24">
      <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6">
        <TeamSlider :team-members="teamMembers" />
      </div>
    </section>

    <!-- ============ 3D TESTIMONIAL DECK ============ -->
    <section class="py-24 bg-white border-b border-slate-100">
      <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6">
        <TestimonialDeck :testimonials="testimonials" />
      </div>
    </section>

    <!-- ============ REDESIGNED FAQ SECTION ============ -->
    <FaqSection :faqs="faqs" />

    <!-- ============ QUICK CONTACT SPLIT SECTION ============ -->
    <section class="grid lg:grid-cols-2">
      <div class="bg-navy-950 p-8 sm:p-16 flex items-center justify-center">
        <div class="w-full max-w-lg">
          <QuickContactForm />
        </div>
      </div>
      <div class="h-80 sm:h-[450px] lg:h-auto min-h-[360px] relative">
        <img src="/images/contact-team2.jpg" alt="SoftPolli Dhaka Office" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-navy-950/20"></div>
        <div class="absolute bottom-8 left-8 right-8 bg-navy-950/90 backdrop-blur-md rounded-2xl p-6 text-white border border-white/10 max-w-md">
          <span class="text-brand font-bold text-xs uppercase tracking-wider block mb-1">Dhaka Headquarters</span>
          <p class="text-xs text-slate-300">2B/4 Ring Road, Shyamoli, Dhaka &bull; Sat - Thu: 8:00 AM - 7:00 PM</p>
        </div>
      </div>
    </section>
  </MainLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import MetaHead from '@/Components/MetaHead.vue';
import HeroSlider from '@/Components/HeroSlider.vue';
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

const servicesCarousel = ref(null);

function scrollCarousel(offset) {
  if (servicesCarousel.value) {
    servicesCarousel.value.scrollBy({ left: offset, behavior: 'smooth' });
  }
}
</script>
