<template>
  <div class="space-y-12" @mouseenter="pauseAutoplay" @mouseleave="startAutoplay">
    <!-- Header Controls: Category Filter Tabs & Navigation Arrows -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 pb-2">
      <!-- Category Filter Pills -->
      <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none">
        <button
          v-for="cat in categories"
          :key="cat.id"
          @click="selectCategory(cat.id)"
          class="px-4 py-2.5 rounded-full text-xs font-bold transition-all whitespace-nowrap flex items-center gap-2"
          :class="selectedCategory === cat.id
            ? 'bg-brand text-white shadow-md shadow-brand/25'
            : 'bg-white/10 text-slate-300 hover:bg-white/20 hover:text-white'"
        >
          <i :class="['fa-solid', cat.icon, selectedCategory === cat.id ? 'text-white' : 'text-slate-400']"></i>
          <span>{{ cat.label }}</span>
          <span
            class="text-[10px] px-1.5 py-0.2 rounded-full font-semibold"
            :class="selectedCategory === cat.id ? 'bg-white/20 text-white' : 'bg-white/10 text-slate-300'"
          >
            {{ cat.count }}
          </span>
        </button>
      </div>

      <!-- Carousel Navigation Controls & Autoplay Indicator -->
      <div class="flex items-center gap-3 shrink-0">
        <button
          @click="scrollPrev"
          class="grid place-items-center w-11 h-11 rounded-full border border-white/20 hover:border-brand hover:bg-brand/20 text-white transition active:scale-95"
          aria-label="Previous service"
        >
          <i class="fa-solid fa-arrow-left text-xs"></i>
        </button>

        <!-- Slide Dots -->
        <div class="hidden sm:flex items-center gap-1.5 px-2">
          <span
            v-for="(s, idx) in filteredServices"
            :key="'dot-' + idx"
            class="h-1.5 rounded-full transition-all duration-300"
            :class="currentSlideIndex === idx ? 'w-6 bg-brand' : 'w-1.5 bg-white/20'"
          ></span>
        </div>

        <button
          @click="scrollNext"
          class="grid place-items-center w-11 h-11 rounded-full bg-brand hover:bg-brand-light text-white transition shadow-md shadow-brand/25 active:scale-95"
          aria-label="Next service"
        >
          <i class="fa-solid fa-arrow-right text-xs"></i>
        </button>
      </div>
    </div>

    <!-- Carousel Slider Track -->
    <div
      ref="carouselRef"
      @scroll="handleScroll"
      class="flex gap-6 overflow-x-auto pb-6 snap-x snap-mandatory scroll-smooth [scrollbar-width:none] [-ms-overflow-style:none]"
    >
      <article
        v-for="(service, i) in filteredServices"
        :key="service.id"
        class="snap-start shrink-0 w-[90%] sm:w-[380px] lg:w-[410px] rounded-3xl bg-navy-950/90 border border-slate-800 hover:border-brand/50 shadow-xl transition-all duration-500 hover:-translate-y-2 flex flex-col justify-between overflow-hidden group"
      >
        <!-- Top Image Visual with Scrim Overlay -->
        <div class="h-52 w-full overflow-hidden relative shrink-0">
          <img
            :src="service.image"
            :alt="service.title"
            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
            @error="onImageError"
          />
          <div class="absolute inset-0 bg-gradient-to-t from-navy-950 via-navy-950/60 to-transparent"></div>

          <!-- Category Tag & Watermark Number -->
          <div class="absolute top-4 left-4 right-4 flex items-center justify-between">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-navy-900/90 backdrop-blur-md text-brand text-[11px] font-extrabold uppercase tracking-wider border border-white/10 shadow-sm">
              <i :class="['fa-solid', getServiceMeta(service.slug).icon, 'text-[10px]']"></i>
              {{ service.tag }}
            </span>
            <span class="text-3xl font-black text-white/30 group-hover:text-brand transition-colors">
              {{ String(i + 1).padStart(2, '0') }}
            </span>
          </div>

          <!-- Bottom Metric Pill -->
          <div class="absolute bottom-3 left-4">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-500/20 backdrop-blur-md text-emerald-400 border border-emerald-500/30 text-[10px] font-bold">
              <i class="fa-solid fa-bolt text-[9px]"></i>
              {{ getServiceMeta(service.slug).metric }}
            </span>
          </div>
        </div>

        <!-- Card Body: Title, Description & Deliverables -->
        <div class="p-6 sm:p-7 flex-1 flex flex-col justify-between">
          <div>
            <h3 class="font-extrabold text-xl text-white group-hover:text-brand transition-colors mb-2.5 leading-snug">
              {{ service.title }}
            </h3>

            <div
              class="text-xs text-slate-300 leading-relaxed mb-6 prose prose-invert prose-xs max-w-none line-clamp-3"
              v-html="sanitizeHtml(service.description)"
            ></div>

            <!-- Deliverables Checkmarks -->
            <div class="space-y-2 mb-6 pt-4 border-t border-slate-800">
              <div
                v-for="(feature, fIdx) in getServiceMeta(service.slug).features.slice(0, 3)"
                :key="fIdx"
                class="flex items-center gap-2.5 text-xs text-slate-300"
              >
                <i class="fa-solid fa-circle-check text-brand text-[11px] shrink-0"></i>
                <span class="truncate">{{ feature }}</span>
              </div>
            </div>
          </div>

          <!-- Bottom Action Buttons -->
          <div class="pt-4 border-t border-slate-800/80 flex items-center justify-between gap-3">
            <Link
              :href="`/services#${service.slug}`"
              class="text-xs font-semibold text-slate-400 hover:text-white transition flex items-center gap-1.5"
            >
              <span>Explore Scope</span>
              <i class="fa-solid fa-angle-right text-[10px]"></i>
            </Link>

            <Link
              :href="`/contact?service=${encodeURIComponent(service.title)}`"
              class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-brand hover:bg-brand-light text-white text-xs font-bold transition-all shadow-md shadow-brand/20 active:scale-95"
            >
              <span>Inquire</span>
              <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-0.5 transition-transform"></i>
            </Link>
          </div>
        </div>
      </article>
    </div>

    <!-- Engineering Delivery Standards Strip -->
    <div class="mt-8 pt-8 border-t border-slate-800">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="flex items-start gap-3.5 p-4 rounded-2xl bg-white/5 border border-white/5">
          <div class="w-10 h-10 rounded-xl bg-brand/20 text-brand flex items-center justify-center text-base shrink-0">
            <i class="fa-solid fa-code-commit"></i>
          </div>
          <div>
            <h4 class="font-bold text-sm text-white">100% Code Ownership</h4>
            <p class="text-xs text-slate-400 mt-0.5">Full proprietary repository transfer upon delivery with zero licensing locks.</p>
          </div>
        </div>

        <div class="flex items-start gap-3.5 p-4 rounded-2xl bg-white/5 border border-white/5">
          <div class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-base shrink-0">
            <i class="fa-solid fa-cubes"></i>
          </div>
          <div>
            <h4 class="font-bold text-sm text-white">Clean Microservices</h4>
            <p class="text-xs text-slate-400 mt-0.5">Modular RESTful architecture built for horizontal autoscaling and easy expansion.</p>
          </div>
        </div>

        <div class="flex items-start gap-3.5 p-4 rounded-2xl bg-white/5 border border-white/5">
          <div class="w-10 h-10 rounded-xl bg-purple-500/20 text-purple-400 flex items-center justify-center text-base shrink-0">
            <i class="fa-solid fa-shield-halved"></i>
          </div>
          <div>
            <h4 class="font-bold text-sm text-white">Security Hardened</h4>
            <p class="text-xs text-slate-400 mt-0.5">OWASP compliance, CSRF/XSS protection, and automated daily off-site backups.</p>
          </div>
        </div>

        <div class="flex items-start gap-3.5 p-4 rounded-2xl bg-white/5 border border-white/5">
          <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center text-base shrink-0">
            <i class="fa-solid fa-headset"></i>
          </div>
          <div>
            <h4 class="font-bold text-sm text-white">Dedicated SLA Support</h4>
            <p class="text-xs text-slate-400 mt-0.5">Under 15-minute response time for critical production infrastructure incidents.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import { sanitizeHtml } from '@/Utils/sanitize';

const props = defineProps({
  services: {
    type: Array,
    required: true,
    default: () => [],
  },
});

const carouselRef = ref(null);
const selectedCategory = ref('all');
const currentSlideIndex = ref(0);
let autoplayInterval = null;

// Service Metadata Enrichment
const serviceMetadata = {
  'software-solutions-consultancy': {
    category: 'software',
    icon: 'fa-cubes-stacked',
    metric: '2-Week Agile Sprints',
    features: ['Microservices & Clean Architecture', 'Dedicated CI/CD Pipeline', 'Full IP & Source Code Transfer', 'Automated Daily Backups'],
  },
  'website-portfolio': {
    category: 'software',
    icon: 'fa-globe',
    metric: '< 1.2s Load Time',
    features: ['Core Web Vitals 95+ Score', 'Interactive Vue 3 / Inertia UI', 'Custom CMS & Content Workflows', 'Mobile-First Responsive Design'],
  },
  'digital-marketing-consultancy': {
    category: 'growth',
    icon: 'fa-chart-line',
    metric: '3.8x Average ROAS',
    features: ['High-Intent Meta & Google Ads', 'Conversion Rate Optimization (CRO)', 'Omnichannel Lead Attribution', 'Full ROI & Analytics Dashboard'],
  },
  'cyber-security-consulting': {
    category: 'security',
    icon: 'fa-shield-halved',
    metric: 'Bank-Grade Hardening',
    features: ['OWASP Top 10 Penetration Testing', 'Cloud Server & Firewall Hardening', 'Automated Vulnerability Scanning', 'Zero-Trust Role-Based ACL'],
  },
  'mobile-app-development': {
    category: 'software',
    icon: 'fa-mobile-screen-button',
    metric: '60 FPS Native Performance',
    features: ['Cross-Platform Flutter/React Native', 'Offline-First SQLite Cache', 'Native Push Notifications & SMS', 'App Store & Play Store Publishing'],
  },
  'domain-web-hosting': {
    category: 'security',
    icon: 'fa-server',
    metric: '99.99% Uptime SLA',
    features: ['NVMe High-Speed Cloud SSD', 'Free Wildcard SSL Encryption', 'DDoS Protection & Cloudflare CDN', '99.99% Guaranteed Server Uptime'],
  },
  'seo-services': {
    category: 'growth',
    icon: 'fa-magnifying-glass-chart',
    metric: 'Top 3 Search Ranking',
    features: ['Technical On-Page Auditing', 'Structured Rich Snippet Schema', 'High-Authority Backlink Profiling', 'Local Search & Google Maps Rank'],
  },
};

const defaultMeta = {
  category: 'software',
  icon: 'fa-laptop-code',
  metric: 'Enterprise Grade',
  features: ['Full Technical Documentation', 'Production Deployment Included', 'Dedicated Senior Engineer', 'SLA Maintenance Guarantee'],
};

function getServiceMeta(slug) {
  return serviceMetadata[slug] || defaultMeta;
}

const categories = computed(() => {
  const allCount = props.services.length;
  const softwareCount = props.services.filter(s => getServiceMeta(s.slug).category === 'software').length;
  const securityCount = props.services.filter(s => getServiceMeta(s.slug).category === 'security').length;
  const growthCount = props.services.filter(s => getServiceMeta(s.slug).category === 'growth').length;

  return [
    { id: 'all', label: 'All Disciplines', icon: 'fa-layer-group', count: allCount },
    { id: 'software', label: 'Software & Mobile', icon: 'fa-laptop-code', count: softwareCount },
    { id: 'security', label: 'Cloud & Security', icon: 'fa-shield-halved', count: securityCount },
    { id: 'growth', label: 'Growth & SEO', icon: 'fa-chart-pie', count: growthCount },
  ];
});

const filteredServices = computed(() => {
  if (selectedCategory.value === 'all') return props.services;
  return props.services.filter(s => getServiceMeta(s.slug).category === selectedCategory.value);
});

function selectCategory(catId) {
  selectedCategory.value = catId;
  currentSlideIndex.value = 0;
  if (carouselRef.value) {
    carouselRef.value.scrollTo({ left: 0, behavior: 'smooth' });
  }
}

function scrollNext() {
  if (!carouselRef.value) return;
  const track = carouselRef.value;
  const cardWidth = track.firstElementChild?.clientWidth || 380;
  const scrollAmount = cardWidth + 24;

  if (track.scrollLeft + track.clientWidth >= track.scrollWidth - 10) {
    track.scrollTo({ left: 0, behavior: 'smooth' });
  } else {
    track.scrollBy({ left: scrollAmount, behavior: 'smooth' });
  }
}

function scrollPrev() {
  if (!carouselRef.value) return;
  const track = carouselRef.value;
  const cardWidth = track.firstElementChild?.clientWidth || 380;
  const scrollAmount = cardWidth + 24;

  if (track.scrollLeft <= 10) {
    track.scrollTo({ left: track.scrollWidth, behavior: 'smooth' });
  } else {
    track.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
  }
}

function handleScroll() {
  if (!carouselRef.value) return;
  const track = carouselRef.value;
  const cardWidth = track.firstElementChild?.clientWidth || 380;
  const index = Math.round(track.scrollLeft / (cardWidth + 24));
  currentSlideIndex.value = Math.max(0, Math.min(index, filteredServices.value.length - 1));
}

function startAutoplay() {
  stopAutoplay();
  autoplayInterval = setInterval(() => {
    scrollNext();
  }, 4500);
}

function pauseAutoplay() {
  stopAutoplay();
}

function stopAutoplay() {
  if (autoplayInterval) {
    clearInterval(autoplayInterval);
    autoplayInterval = null;
  }
}

function onImageError(e) {
  e.target.src = '/images/service-2.png';
}

onMounted(() => {
  startAutoplay();
});

onUnmounted(() => {
  stopAutoplay();
});
</script>

