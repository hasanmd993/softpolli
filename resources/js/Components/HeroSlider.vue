<template>
  <div class="relative w-full h-[650px] lg:h-[calc(100vh-140px)] min-h-[600px] bg-navy-950 overflow-hidden select-none">
    <div ref="swiperContainer" class="swiper w-full h-full">
      <div class="swiper-wrapper">
        <!-- Slide 1: Software Solutions -->
        <div class="swiper-slide relative w-full h-full overflow-hidden flex items-center pt-16 sm:pt-20 lg:pt-24 pb-10 sm:pb-14">
          <div class="absolute inset-0 bg-cover bg-center brightness-[0.45] scale-105 transition-transform duration-1000" style="background-image: url('/images/hero-team.png');"></div>
          <div class="absolute inset-0 bg-gradient-to-r from-navy-950 via-navy-950/80 to-transparent z-10"></div>
          
          <div class="relative z-20 max-w-[92%] xl:max-w-[85%] mx-auto px-6 w-full">
            <div class="max-w-2xl">
              <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-brand/20 border border-brand/40 text-brand-light text-xs font-bold uppercase tracking-wider mb-5">
                <i class="fa-solid fa-code"></i> Software Solutions
              </span>
              <h1 class="text-3xl sm:text-5xl xl:text-6xl font-extrabold text-white leading-[1.1] mb-6">
                Smart Software <span class="text-brand">Solutions</span> For Modern Businesses
              </h1>
              <p class="text-slate-300 text-sm sm:text-base leading-relaxed mb-8 max-w-xl">
                We build reliable, scalable and future-ready enterprise software that helps businesses automate operations, improve efficiency, and accelerate revenue.
              </p>
              <div class="flex flex-wrap items-center gap-4">
                <Link href="/services" class="inline-flex items-center gap-2 bg-brand hover:bg-brand-light text-white text-xs sm:text-sm font-bold px-7 py-4 rounded-full transition shadow-lg shadow-brand/25">
                  Explore Services <i class="fa-solid fa-arrow-right text-xs"></i>
                </Link>
                <Link href="/portfolio" class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white text-xs sm:text-sm font-semibold px-7 py-4 rounded-full transition backdrop-blur">
                  View Portfolio <i class="fa-solid fa-arrow-right text-xs"></i>
                </Link>
              </div>
            </div>
          </div>
        </div>

        <!-- Slide 2: Web Applications -->
        <div class="swiper-slide relative w-full h-full overflow-hidden flex items-center pt-16 sm:pt-20 lg:pt-24 pb-10 sm:pb-14">
          <div class="absolute inset-0 bg-cover bg-center brightness-[0.45] scale-105 transition-transform duration-1000" style="background-image: url('/images/skills-1.jpg');"></div>
          <div class="absolute inset-0 bg-gradient-to-r from-navy-950 via-navy-950/80 to-transparent z-10"></div>
          
          <div class="relative z-20 max-w-[92%] xl:max-w-[85%] mx-auto px-6 w-full">
            <div class="max-w-2xl">
              <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-brand/20 border border-brand/40 text-brand-light text-xs font-bold uppercase tracking-wider mb-5">
                <i class="fa-solid fa-laptop-code"></i> Web Engineering
              </span>
              <h1 class="text-3xl sm:text-5xl xl:text-6xl font-extrabold text-white leading-[1.1] mb-6">
                Powerful Web <span class="text-brand">Applications</span> Built For Scale
              </h1>
              <p class="text-slate-300 text-sm sm:text-base leading-relaxed mb-8 max-w-xl">
                From high-conversion corporate web platforms to complex SaaS applications, we deliver blazing-fast, secure, and intuitive digital experiences.
              </p>
              <div class="flex flex-wrap items-center gap-4">
                <Link href="/contact" class="inline-flex items-center gap-2 bg-brand hover:bg-brand-light text-white text-xs sm:text-sm font-bold px-7 py-4 rounded-full transition shadow-lg shadow-brand/25">
                  Start A Project <i class="fa-solid fa-arrow-right text-xs"></i>
                </Link>
                <Link href="/pricing" class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white text-xs sm:text-sm font-semibold px-7 py-4 rounded-full transition backdrop-blur">
                  Check Pricing <i class="fa-solid fa-arrow-right text-xs"></i>
                </Link>
              </div>
            </div>
          </div>
        </div>

        <!-- Slide 3: E-Commerce & Retail -->
        <div class="swiper-slide relative w-full h-full overflow-hidden flex items-center pt-16 sm:pt-20 lg:pt-24 pb-10 sm:pb-14">
          <div class="absolute inset-0 bg-cover bg-center brightness-[0.45] scale-105 transition-transform duration-1000" style="background-image: url('/images/skills-2.jpg');"></div>
          <div class="absolute inset-0 bg-gradient-to-r from-navy-950 via-navy-950/80 to-transparent z-10"></div>
          
          <div class="relative z-20 max-w-[92%] xl:max-w-[85%] mx-auto px-6 w-full">
            <div class="max-w-2xl">
              <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-brand/20 border border-brand/40 text-brand-light text-xs font-bold uppercase tracking-wider mb-5">
                <i class="fa-solid fa-cart-shopping"></i> E-Commerce & POS
              </span>
              <h1 class="text-3xl sm:text-5xl xl:text-6xl font-extrabold text-white leading-[1.1] mb-6">
                Grow Your <span class="text-brand">Online Business</span> With Modern Tech
              </h1>
              <p class="text-slate-300 text-sm sm:text-base leading-relaxed mb-8 max-w-xl">
                Build an automated online store with unified inventory sync, instant payment gateway integration, and real-time branch analytics.
              </p>
              <div class="flex flex-wrap items-center gap-4">
                <Link href="/contact" class="inline-flex items-center gap-2 bg-brand hover:bg-brand-light text-white text-xs sm:text-sm font-bold px-7 py-4 rounded-full transition shadow-lg shadow-brand/25">
                  Get In Touch <i class="fa-solid fa-arrow-right text-xs"></i>
                </Link>
                <Link href="/services" class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white text-xs sm:text-sm font-semibold px-7 py-4 rounded-full transition backdrop-blur">
                  Our Services <i class="fa-solid fa-arrow-right text-xs"></i>
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Navigation Arrows -->
      <div class="absolute bottom-4 right-4 sm:bottom-8 sm:right-8 z-30 flex items-center gap-2 sm:gap-3">
        <button ref="prevBtn" class="w-9 h-9 sm:w-12 sm:h-12 rounded-full border border-white/20 bg-navy-950/60 hover:bg-brand hover:border-brand text-white transition grid place-items-center backdrop-blur text-xs sm:text-sm" aria-label="Previous slide">
          <i class="fa-solid fa-arrow-left"></i>
        </button>
        <button ref="nextBtn" class="w-9 h-9 sm:w-12 sm:h-12 rounded-full border border-white/20 bg-navy-950/60 hover:bg-brand hover:border-brand text-white transition grid place-items-center backdrop-blur text-xs sm:text-sm" aria-label="Next slide">
          <i class="fa-solid fa-arrow-right"></i>
        </button>
      </div>

      <!-- Pagination Bullets -->
      <div ref="paginationEl" class="swiper-pagination !bottom-4 sm:!bottom-8 !left-6 sm:!left-12 !w-auto z-30"></div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay, EffectFade } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/effect-fade';

const swiperContainer = ref(null);
const prevBtn = ref(null);
const nextBtn = ref(null);
const paginationEl = ref(null);
let swiperInstance = null;

onMounted(() => {
  if (swiperContainer.value) {
    swiperInstance = new Swiper(swiperContainer.value, {
      modules: [Navigation, Pagination, Autoplay, EffectFade],
      effect: 'fade',
      fadeEffect: { crossFade: true },
      speed: 1000,
      loop: true,
      autoplay: {
        delay: 6000,
        disableOnInteraction: false,
      },
      navigation: {
        nextEl: nextBtn.value,
        prevEl: prevBtn.value,
      },
      pagination: {
        el: paginationEl.value,
        clickable: true,
      },
    });
  }
});

onUnmounted(() => {
  if (swiperInstance) {
    swiperInstance.destroy();
  }
});
</script>

<style scoped>
:deep(.swiper-slide) {
  display: flex !important;
  align-items: center;
}
:deep(.swiper-pagination-bullet) {
  width: 10px;
  height: 10px;
  background: rgba(255, 255, 255, 0.4);
  opacity: 1;
  border-radius: 9999px;
  transition: all 0.3s ease;
}
:deep(.swiper-pagination-bullet-active) {
  width: 28px;
  background: #f1592a;
}
</style>
