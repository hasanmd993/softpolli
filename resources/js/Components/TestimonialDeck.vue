<template>
  <div class="grid lg:grid-cols-12 gap-12 items-center">
    <!-- Left: 3D Stacked Image Deck -->
    <div class="lg:col-span-5 relative flex justify-center">
      <div class="relative w-full max-w-[380px] h-[400px] perspective-1000">
        <div
          v-for="(t, idx) in testimonials"
          :key="t.name"
          @click="activeIndex = idx"
          class="absolute inset-0 rounded-3xl overflow-hidden shadow-2xl transition-all duration-700 cursor-pointer border border-white/20"
          :style="getCardStyle(idx)"
        >
          <img :src="t.src" :alt="t.name" class="w-full h-full object-cover" />
          <div class="absolute inset-0 bg-gradient-to-t from-navy-950/80 via-transparent to-transparent"></div>
          
          <div class="absolute bottom-5 left-5 right-5 text-white">
            <h5 class="font-bold text-sm">{{ t.name }}</h5>
            <p class="text-[11px] text-slate-300">{{ t.designation }} &bull; {{ t.company }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Right: Review Quote & Details -->
    <div class="lg:col-span-7">
      <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand/10 text-brand text-xs font-bold uppercase tracking-wider mb-4">
        <i class="fa-solid fa-star text-[10px]"></i> Client Testimonials
      </span>

      <div class="relative min-h-[160px] mb-8">
        <i class="fa-solid fa-quote-left text-4xl text-brand/20 absolute -top-4 -left-2 -z-10"></i>
        <div class="text-slate-600 text-sm sm:text-base leading-relaxed italic prose prose-sm max-w-none prose-slate [&_p]:mb-1" v-html="sanitizeHtml(currentTestimonial.quote)"></div>
      </div>

      <!-- Author Bio & Category -->
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 pt-6 border-t border-slate-200">
        <div>
          <h4 class="font-extrabold text-lg text-navy-900">{{ currentTestimonial.name }}</h4>
          <p class="text-xs text-brand font-semibold">{{ currentTestimonial.designation }} &bull; {{ currentTestimonial.company }}</p>
          <span class="inline-block mt-2 px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-[11px] font-medium">
            Project: {{ currentTestimonial.category }}
          </span>
        </div>

        <!-- Controls -->
        <div class="flex items-center gap-3">
          <button
            @click="prev"
            class="w-11 h-11 rounded-full border border-slate-200 hover:border-brand hover:text-brand transition grid place-items-center text-sm shadow-sm"
            aria-label="Previous review"
          >
            <i class="fa-solid fa-arrow-left"></i>
          </button>
          <button
            @click="next"
            class="w-11 h-11 rounded-full bg-brand hover:bg-brand-light text-white transition grid place-items-center text-sm shadow-md shadow-brand/25"
            aria-label="Next review"
          >
            <i class="fa-solid fa-arrow-right"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { sanitizeHtml } from '@/Utils/sanitize';

const props = defineProps({
  testimonials: {
    type: Array,
    required: true,
  },
});

const activeIndex = ref(0);

const currentTestimonial = computed(() => {
  return props.testimonials[activeIndex.value] || props.testimonials[0];
});

function getCardStyle(index) {
  const diff = (index - activeIndex.value + props.testimonials.length) % props.testimonials.length;
  const isMobile = typeof window !== 'undefined' ? window.innerWidth < 640 : false;
  const offset = isMobile ? 12 : 24;

  if (diff === 0) {
    return {
      transform: 'translate3d(0, 0, 0) scale(1) rotate(0deg)',
      zIndex: 20,
      opacity: 1,
    };
  } else if (diff === 1) {
    return {
      transform: `translate3d(${offset}px, -16px, -40px) scale(0.92) rotate(3deg)`,
      zIndex: 10,
      opacity: 0.75,
    };
  } else {
    return {
      transform: `translate3d(-${offset}px, -20px, -80px) scale(0.85) rotate(-3deg)`,
      zIndex: 5,
      opacity: 0.45,
    };
  }
}

function next() {
  activeIndex.value = (activeIndex.value + 1) % props.testimonials.length;
}

function prev() {
  activeIndex.value = (activeIndex.value - 1 + props.testimonials.length) % props.testimonials.length;
}
</script>
