<template>
  <div class="relative">
    <!-- Header with Controls -->
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6 mb-12">
      <div>
        <p class="text-brand font-bold tracking-[0.2em] text-xs uppercase mb-3 relative inline-block">
          EXPERT TEAM
          <span class="absolute -bottom-1 left-0 w-8 h-[2px] bg-brand"></span>
        </p>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-white">
          Excellent Team Members
        </h2>
      </div>

    <!-- Controls -->
    <div v-if="maxIndex > 0" class="flex items-center gap-3">
      <button
        @click="handleManualPrev"
        class="grid place-items-center w-11 h-11 rounded-full border border-white/20 text-white hover:bg-white/10 transition text-sm shadow-sm"
        aria-label="Previous team member"
      >
        <i class="fa-solid fa-arrow-left"></i>
      </button>

      <button
        @click="handleManualNext"
        class="grid place-items-center w-11 h-11 rounded-full bg-brand hover:bg-brand-light text-white transition text-sm shadow-md shadow-brand/25"
        aria-label="Next team member"
      >
        <i class="fa-solid fa-arrow-right"></i>
      </button>
    </div>
  </div>

  <!-- Slider Container -->
  <div
    ref="sliderWrapper"
    class="overflow-hidden"
    @mouseenter="pauseAutoplay"
    @mouseleave="resumeAutoplay"
    @focusin="pauseAutoplay"
    @focusout="resumeAutoplay"
  >
      <div
        class="flex gap-6 transition-transform duration-500 ease-out"
        :style="{ transform: `translateX(-${currentIndex * (cardWidth + 24)}px)` }"
      >
        <div
          v-for="member in teamMembers"
          :key="member.name"
          class="shrink-0 relative rounded-2xl overflow-hidden bg-slate-800 group h-[390px]"
          :style="{ width: `${cardWidth}px` }"
        >
          <img
            :src="member.image"
            :alt="member.name"
            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
          />

          <!-- Overlay Card -->
          <div class="absolute bottom-3 left-3 right-3 bg-navy-950/90 backdrop-blur-md rounded-2xl p-4 flex items-center justify-between border border-white/10">
            <div>
              <h4 class="font-bold text-sm text-white">{{ member.name }}</h4>
              <p class="text-[11px] text-slate-400 mt-0.5">{{ member.role }}</p>
            </div>

            <!-- Social Links -->
            <div class="flex items-center gap-2 text-slate-300 text-xs">
              <a
                v-if="member.social?.facebook"
                :href="member.social.facebook"
                target="_blank"
                class="w-7 h-7 rounded-full bg-white/10 hover:bg-brand hover:text-white transition grid place-items-center"
              >
                <i class="fa-brands fa-facebook-f text-[10px]"></i>
              </a>
              <a
                v-if="member.social?.linkedin"
                :href="member.social.linkedin"
                target="_blank"
                class="w-7 h-7 rounded-full bg-white/10 hover:bg-brand hover:text-white transition grid place-items-center"
              >
                <i class="fa-brands fa-linkedin-in text-[10px]"></i>
              </a>
              <a
                v-if="member.social?.website"
                :href="member.social.website"
                target="_blank"
                class="w-7 h-7 rounded-full bg-white/10 hover:bg-brand hover:text-white transition grid place-items-center"
              >
                <i class="fa-solid fa-globe text-[10px]"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';

const props = defineProps({
  teamMembers: {
    type: Array,
    required: true,
  },
});

const sliderWrapper = ref(null);
const currentIndex = ref(0);
const containerWidth = ref(1200);
const visibleCards = ref(4);
const isPaused = ref(false);
let autoplayTimer = null;

function updateDimensions() {
  if (sliderWrapper.value?.clientWidth) {
    containerWidth.value = sliderWrapper.value.clientWidth;
  } else if (typeof window !== 'undefined') {
    containerWidth.value = window.innerWidth * 0.9;
  }

  const width = typeof window !== 'undefined' ? window.innerWidth : 1200;
  if (width >= 1024) {
    visibleCards.value = 4;
  } else if (width >= 640) {
    visibleCards.value = 2;
  } else {
    visibleCards.value = 1;
  }
}

const cardWidth = computed(() => {
  const gap = 24;
  const width = containerWidth.value || 1200;
  if (visibleCards.value === 1) {
    return width;
  }
  return Math.max(220, (width - gap * (visibleCards.value - 1)) / visibleCards.value);
});

const maxIndex = computed(() => {
  return Math.max(0, props.teamMembers.length - visibleCards.value);
});

function next() {
  if (maxIndex.value <= 0) return;
  if (currentIndex.value < maxIndex.value) {
    currentIndex.value++;
  } else {
    currentIndex.value = 0;
  }
}

function prev() {
  if (maxIndex.value <= 0) return;
  if (currentIndex.value > 0) {
    currentIndex.value--;
  } else {
    currentIndex.value = maxIndex.value;
  }
}

function handleManualNext() {
  next();
  restartAutoplay();
}

function handleManualPrev() {
  prev();
  restartAutoplay();
}

function startAutoplay() {
  stopAutoplay();
  if (maxIndex.value <= 0) return;
  autoplayTimer = setInterval(() => {
    if (!isPaused.value) {
      next();
    }
  }, 3500);
}

function stopAutoplay() {
  if (autoplayTimer) {
    clearInterval(autoplayTimer);
    autoplayTimer = null;
  }
}

function restartAutoplay() {
  startAutoplay();
}

function pauseAutoplay() {
  isPaused.value = true;
}

function resumeAutoplay() {
  isPaused.value = false;
}

onMounted(() => {
  updateDimensions();
  startAutoplay();
  window.addEventListener('resize', updateDimensions);
});

onUnmounted(() => {
  stopAutoplay();
  window.removeEventListener('resize', updateDimensions);
});
</script>
