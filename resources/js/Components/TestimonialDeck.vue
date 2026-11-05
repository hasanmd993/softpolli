<template>
  <div class="relative" @mouseenter="pauseAutoplay" @mouseleave="startAutoplay">
    <!-- Main Spotlight Container -->
    <div class="relative bg-white rounded-3xl border border-slate-200/90 shadow-xl shadow-navy-950/5 overflow-hidden">
      <!-- Decorative Ambient Gradient Blobs -->
      <div class="absolute -top-24 -right-24 w-96 h-96 bg-brand/5 rounded-full blur-3xl pointer-events-none"></div>
      <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-emerald-500/5 rounded-full blur-3xl pointer-events-none"></div>

      <div class="relative grid lg:grid-cols-12 gap-8 lg:gap-12 items-stretch p-6 sm:p-10 lg:p-14">
        <!-- Left: Client Visual Profile & Credentials (5 Cols) -->
        <div class="lg:col-span-5 flex flex-col justify-between">
          <div class="relative group">
            <!-- Main Photo Container -->
            <div class="relative w-full aspect-[4/3] sm:aspect-[16/11] lg:aspect-[4/4] rounded-2xl overflow-hidden bg-slate-100 shadow-md border border-slate-200/80">
              <img
                :src="currentTestimonial.src"
                :alt="currentTestimonial.name"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                @error="onImageError"
              />
              <div class="absolute inset-0 bg-gradient-to-t from-navy-950/80 via-navy-950/20 to-transparent"></div>

              <!-- Overlaid Client Details for Mobile / Photo Base -->
              <div class="absolute bottom-4 left-4 right-4 text-white">
                <div class="flex items-center gap-2 mb-1">
                  <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/90 backdrop-blur-sm text-[11px] font-bold tracking-wide uppercase shadow-sm">
                    <i class="fa-solid fa-circle-check text-[10px]"></i> Verified Client
                  </span>
                  <span class="text-[11px] bg-white/20 backdrop-blur-sm px-2 py-0.5 rounded-full font-medium">
                    {{ currentTestimonial.category }}
                  </span>
                </div>
                <h4 class="font-bold text-base sm:text-lg text-white drop-shadow-sm">{{ currentTestimonial.name }}</h4>
                <p class="text-xs text-slate-200 truncate">{{ currentTestimonial.designation }} &bull; {{ currentTestimonial.company }}</p>
              </div>
            </div>

            <!-- Floating Trust Badge -->
            <div class="hidden sm:flex absolute -bottom-4 -right-4 bg-white rounded-xl shadow-lg border border-slate-100 p-3 items-center gap-3">
              <div class="w-10 h-10 rounded-lg bg-amber-500/10 text-amber-500 flex items-center justify-center text-lg font-black">
                <i class="fa-solid fa-star"></i>
              </div>
              <div>
                <div class="flex items-center text-amber-400 text-xs gap-0.5">
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                </div>
                <span class="text-[11px] font-bold text-navy-900 block">5.0 / 5.0 Rating</span>
              </div>
            </div>
          </div>

          <!-- Bottom Client Quick Tabs (Desktop) -->
          <div class="hidden lg:grid grid-cols-4 gap-2 mt-6 pt-4 border-t border-slate-100">
            <button
              v-for="(t, idx) in testimonials"
              :key="'thumb-' + idx"
              @click="goTo(idx)"
              class="relative rounded-xl overflow-hidden p-1 transition-all text-left flex flex-col items-center group"
              :class="activeIndex === idx ? 'ring-2 ring-brand bg-brand/5 shadow-sm' : 'opacity-60 hover:opacity-100'"
              :title="t.name"
            >
              <div class="w-10 h-10 rounded-lg overflow-hidden bg-slate-200 mb-1 border border-slate-200">
                <img :src="t.src" :alt="t.name" class="w-full h-full object-cover" />
              </div>
              <span class="text-[10px] font-bold text-slate-700 truncate w-full text-center">{{ t.name.split(' ')[0] }}</span>
            </button>
          </div>
        </div>

        <!-- Right: Quote Content & Verification (7 Cols) -->
        <div class="lg:col-span-7 flex flex-col justify-between">
          <div>
            <!-- Top Metric / Rating Bar -->
            <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
              <div class="flex items-center gap-2">
                <div class="flex items-center text-amber-400 text-sm gap-1">
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                </div>
                <span class="text-xs font-bold text-slate-800 ml-1">5.0 Star Feedback</span>
                <span class="text-slate-300">&bull;</span>
                <span class="text-xs text-slate-500 font-medium">Enterprise Tier</span>
              </div>

              <!-- Counter pill -->
              <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-semibold">
                <span>{{ String(activeIndex + 1).padStart(2, '0') }}</span>
                <span class="text-slate-300">/</span>
                <span>{{ String(testimonials.length).padStart(2, '0') }}</span>
              </div>
            </div>

            <!-- Quote Text with Ambient Icon -->
            <div class="relative min-h-[140px] sm:min-h-[170px] flex items-center">
              <i class="fa-solid fa-quote-left text-5xl sm:text-6xl text-brand/10 absolute -top-4 sm:-top-6 -left-3 select-none pointer-events-none"></i>
              <blockquote class="text-slate-700 text-base sm:text-lg lg:text-xl font-normal leading-relaxed italic prose prose-slate max-w-none [&_p]:mb-1 relative z-10">
                <div v-html="sanitizeHtml(currentTestimonial.quote)"></div>
              </blockquote>
            </div>

            <!-- Project Category & Deliverable Tag -->
            <div class="mt-6 flex flex-wrap items-center gap-2">
              <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-brand/10 text-brand text-xs font-bold">
                <i class="fa-solid fa-diagram-project text-[11px]"></i>
                {{ currentTestimonial.category }}
              </span>
              <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-semibold border border-emerald-100">
                <i class="fa-solid fa-check text-[10px]"></i> Production Deployed
              </span>
              <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-slate-100 text-slate-600 text-xs font-semibold">
                <i class="fa-solid fa-building text-[10px]"></i> {{ currentTestimonial.company }}
              </span>
            </div>
          </div>

          <!-- Bottom Navigation Bar & Author Details -->
          <div class="pt-8 mt-8 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <div>
              <h4 class="font-black text-lg sm:text-xl text-navy-950 tracking-tight">{{ currentTestimonial.name }}</h4>
              <p class="text-xs sm:text-sm text-slate-500 font-medium">
                {{ currentTestimonial.designation }} &mdash; <span class="text-brand font-semibold">{{ currentTestimonial.company }}</span>
              </p>
            </div>

            <!-- Navigation Controls + Autoplay Bar -->
            <div class="flex items-center gap-3">
              <button
                @click="prev"
                class="w-11 h-11 rounded-full border border-slate-200 hover:border-brand hover:text-brand hover:bg-brand/5 text-slate-600 transition flex items-center justify-center text-sm shadow-sm active:scale-95"
                aria-label="Previous testimonial"
              >
                <i class="fa-solid fa-arrow-left"></i>
              </button>
              
              <!-- Mini Progress Indicators -->
              <div class="flex items-center gap-1.5 px-1">
                <button
                  v-for="(t, idx) in testimonials"
                  :key="'dot-' + idx"
                  @click="goTo(idx)"
                  class="h-2 rounded-full transition-all duration-300"
                  :class="activeIndex === idx ? 'w-7 bg-brand' : 'w-2 bg-slate-200 hover:bg-slate-300'"
                  :aria-label="`Go to review ${idx + 1}`"
                ></button>
              </div>

              <button
                @click="next"
                class="w-11 h-11 rounded-full bg-brand hover:bg-brand-light text-white transition flex items-center justify-center text-sm shadow-md shadow-brand/25 active:scale-95"
                aria-label="Next testimonial"
              >
                <i class="fa-solid fa-arrow-right"></i>
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Autoplay Smooth Progress Line -->
      <div class="h-1 bg-slate-100 w-full overflow-hidden">
        <div
          class="h-full bg-gradient-to-r from-brand to-brand-light transition-all duration-100 ease-linear"
          :style="{ width: `${progressPercentage}%` }"
        ></div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { sanitizeHtml } from '@/Utils/sanitize';

const props = defineProps({
  testimonials: {
    type: Array,
    required: true,
    default: () => [],
  },
});

const activeIndex = ref(0);
const progressPercentage = ref(0);
let timer = null;
let progressTimer = null;
const AUTOPLAY_INTERVAL = 6000; // 6 seconds per slide
const PROGRESS_STEP = 50; // update progress every 50ms

const currentTestimonial = computed(() => {
  if (!props.testimonials || props.testimonials.length === 0) {
    return {
      name: 'Valued Client',
      designation: 'Enterprise Leader',
      company: 'Corporate Client',
      category: 'Software Solutions',
      quote: 'SoftPolli delivers world-class engineering with unmatched support.',
      src: '/images/t1.jpg',
    };
  }
  return props.testimonials[activeIndex.value] || props.testimonials[0];
});

function next() {
  if (!props.testimonials.length) return;
  activeIndex.value = (activeIndex.value + 1) % props.testimonials.length;
  resetProgress();
}

function prev() {
  if (!props.testimonials.length) return;
  activeIndex.value = (activeIndex.value - 1 + props.testimonials.length) % props.testimonials.length;
  resetProgress();
}

function goTo(index) {
  if (index >= 0 && index < props.testimonials.length) {
    activeIndex.value = index;
    resetProgress();
  }
}

function resetProgress() {
  progressPercentage.value = 0;
}

function startAutoplay() {
  stopAutoplay();
  if (props.testimonials.length <= 1) return;

  progressTimer = setInterval(() => {
    progressPercentage.value += (PROGRESS_STEP / AUTOPLAY_INTERVAL) * 100;
    if (progressPercentage.value >= 100) {
      next();
    }
  }, PROGRESS_STEP);
}

function pauseAutoplay() {
  stopAutoplay();
}

function stopAutoplay() {
  if (timer) clearInterval(timer);
  if (progressTimer) clearInterval(progressTimer);
  timer = null;
  progressTimer = null;
}

function onImageError(e) {
  e.target.src = '/images/t1.jpg';
}

function handleKeydown(e) {
  if (e.key === 'ArrowLeft') {
    prev();
  } else if (e.key === 'ArrowRight') {
    next();
  }
}

onMounted(() => {
  startAutoplay();
  window.addEventListener('keydown', handleKeydown);
});

onUnmounted(() => {
  stopAutoplay();
  window.removeEventListener('keydown', handleKeydown);
});
</script>
