<template>
  <section id="faq" class="py-24 bg-gradient-to-b from-slate-50/70 via-white to-slate-50/70 relative overflow-hidden">
    <!-- Ambient background decorations -->
    <div class="absolute -top-40 -right-40 w-96 h-96 bg-brand/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-navy-900/5 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6 relative z-10">
      <!-- Section Header -->
      <div class="max-w-3xl mb-12">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-brand/10 border border-brand/20 text-brand text-xs font-bold uppercase tracking-wider mb-4">
          <span class="w-2 h-2 rounded-full bg-brand animate-pulse"></span>
          FREQUENTLY ASKED QUESTIONS
        </div>
        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-navy-950 tracking-tight leading-tight">
          Got Questions? <br class="hidden sm:inline" />
          <span class="bg-gradient-to-r from-brand via-orange-600 to-navy-900 bg-clip-text text-transparent">
            Everything You Need To Know
          </span>
        </h2>
        <p class="text-slate-600 text-sm sm:text-base mt-4 leading-relaxed">
          Clear answers about our agile engineering process, tech stack, SLA warranties, pricing models, and source code ownership.
        </p>
      </div>

      <!-- Controls: Category Filter + Search Bar -->
      <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4 mb-10 pb-6 border-b border-slate-200/80">
        <!-- Category Filter Tabs -->
        <div class="flex flex-wrap items-center gap-2">
          <button
            v-for="cat in categories"
            :key="cat"
            type="button"
            @click="activeCategory = cat"
            :class="[
              'px-4 py-2 rounded-xl text-xs font-bold transition-all duration-200 cursor-pointer select-none',
              activeCategory === cat
                ? 'bg-navy-950 text-white shadow-md shadow-navy-950/20 scale-[1.02]'
                : 'bg-white text-slate-600 hover:text-navy-900 hover:bg-slate-100 border border-slate-200'
            ]"
          >
            {{ cat }}
          </button>
        </div>

        <!-- Realtime Search Input -->
        <div class="relative w-full md:w-72">
          <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search questions or keywords..."
            class="w-full pl-9 pr-8 py-2 rounded-xl border border-slate-200 text-xs text-navy-900 bg-white placeholder:text-slate-400 focus:outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition"
          />
          <button
            v-if="searchQuery"
            @click="searchQuery = ''"
            type="button"
            class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-navy-900 text-xs"
          >
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>
      </div>

      <!-- Main Grid: Left Accordion Deck, Right Consultation Card -->
      <div class="grid lg:grid-cols-12 gap-8 lg:gap-12 items-start">
        <!-- Accordion Deck (8 Columns) -->
        <div class="lg:col-span-8 space-y-4">
          <div
            v-if="filteredFaqs.length === 0"
            class="bg-white border border-dashed border-slate-300 rounded-3xl p-12 text-center"
          >
            <div class="w-14 h-14 mx-auto rounded-2xl bg-brand/10 text-brand grid place-items-center text-xl mb-4">
              <i class="fa-solid fa-circle-question"></i>
            </div>
            <h3 class="text-base font-bold text-navy-950">No matching questions found</h3>
            <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
              We couldn't find any questions matching "{{ searchQuery }}". Try another keyword or reach out directly to our engineering team.
            </p>
            <button
              @click="searchQuery = ''; activeCategory = 'All Topics'"
              type="button"
              class="mt-4 px-4 py-2 bg-navy-900 text-white rounded-xl text-xs font-bold hover:bg-brand transition"
            >
              Reset Filters
            </button>
          </div>

          <div
            v-for="(faq, index) in filteredFaqs"
            :key="faq.id || index"
            :class="[
              'rounded-2xl transition-all duration-300 border overflow-hidden bg-white',
              openIndex === index
                ? 'border-brand/50 shadow-lg shadow-brand/5 ring-1 ring-brand/20 bg-gradient-to-r from-brand/[0.02] to-transparent'
                : 'border-slate-200/90 hover:border-slate-300 hover:shadow-md'
            ]"
          >
            <!-- Accordion Header Button -->
            <button
              type="button"
              @click="toggleFaq(index)"
              class="w-full text-left p-6 flex items-center justify-between gap-4 cursor-pointer select-none transition"
            >
              <div class="flex items-center gap-4">
                <span
                  :class="[
                    'w-9 h-9 rounded-xl font-mono text-xs font-bold flex items-center justify-center shrink-0 transition-colors',
                    openIndex === index
                      ? 'bg-brand text-white shadow-sm'
                      : 'bg-slate-100 text-slate-600'
                  ]"
                >
                  {{ String(index + 1).padStart(2, '0') }}
                </span>
                <span class="text-sm sm:text-base font-bold text-navy-950 leading-snug">
                  {{ faq.q || faq.question }}
                </span>
              </div>

              <!-- Animated Toggle Indicator -->
              <span
                :class="[
                  'w-8 h-8 rounded-full shrink-0 flex items-center justify-center transition-all duration-300 text-xs',
                  openIndex === index
                    ? 'bg-brand text-white rotate-180'
                    : 'bg-slate-100 text-slate-600 hover:bg-brand/10 hover:text-brand'
                ]"
              >
                <i class="fa-solid fa-chevron-down"></i>
              </span>
            </button>

            <!-- Expandable Answer Body -->
            <div
              v-show="openIndex === index"
              class="px-6 pb-6 pt-2 border-t border-slate-100 animate-fadeIn"
            >
              <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                {{ faq.a || faq.answer }}
              </p>

              <!-- Helpful Micro Footer -->
              <div class="mt-4 pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3 text-xs">
                <div class="flex items-center gap-2 text-slate-400">
                  <i class="fa-solid fa-shield-halved text-brand text-[11px]"></i>
                  <span>SoftPolli SLA & Quality Guarantee</span>
                </div>
                <div class="flex items-center gap-2">
                  <span class="text-slate-400">Was this helpful?</span>
                  <button
                    type="button"
                    @click="markHelpful(index)"
                    :disabled="helpfulState[index]"
                    :class="[
                      'px-2.5 py-1 rounded-lg text-[11px] font-semibold transition',
                      helpfulState[index]
                        ? 'bg-emerald-50 text-emerald-600'
                        : 'bg-slate-100 text-slate-600 hover:bg-emerald-50 hover:text-emerald-600'
                    ]"
                  >
                    <i class="fa-regular fa-thumbs-up mr-1"></i>
                    {{ helpfulState[index] ? 'Thank you!' : 'Yes' }}
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Sticky Consultation Card (4 Columns) -->
        <div class="lg:col-span-4 lg:sticky lg:top-28">
          <div class="bg-gradient-to-br from-navy-950 via-navy-900 to-navy-950 rounded-3xl p-8 text-white border border-white/10 shadow-2xl relative overflow-hidden">
            <!-- Background Glow -->
            <div class="absolute -right-16 -top-16 w-48 h-48 bg-brand/20 rounded-full blur-2xl"></div>

            <!-- Online Status & Avatars -->
            <div class="flex items-center justify-between gap-3 mb-6 relative z-10">
              <div class="flex -space-x-2.5 overflow-hidden">
                <img
                  src="/images/taukir_gemini.png"
                  alt="Taukir Ahmed"
                  class="inline-block h-10 w-10 rounded-full ring-2 ring-navy-950 object-cover"
                />
                <img
                  src="/images/sabbir.png"
                  alt="Sabbir Ahmed"
                  class="inline-block h-10 w-10 rounded-full ring-2 ring-navy-950 object-cover"
                />
                <img
                  src="/images/Azmir_Hossain_Gemini.png"
                  alt="Azmir Hossain"
                  class="inline-block h-10 w-10 rounded-full ring-2 ring-navy-950 object-cover"
                />
              </div>
              <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 text-[11px] font-semibold">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                Specialists Online
              </div>
            </div>

            <!-- Card Headline & Copy -->
            <div class="relative z-10">
              <h3 class="text-xl font-black text-white leading-tight mb-2">
                Still have unanswered questions?
              </h3>
              <p class="text-slate-300 text-xs leading-relaxed mb-6">
                Speak directly with our senior software architects about your system requirements, server infrastructure, or timeline constraints.
              </p>

              <!-- Quick Specs Callout -->
              <div class="space-y-2.5 mb-6 text-xs text-slate-300">
                <div class="flex items-center gap-2.5">
                  <i class="fa-solid fa-circle-check text-brand text-xs"></i>
                  <span>Zero-obligation engineering estimate</span>
                </div>
                <div class="flex items-center gap-2.5">
                  <i class="fa-solid fa-circle-check text-brand text-xs"></i>
                  <span>Architecture & technology audit</span>
                </div>
                <div class="flex items-center gap-2.5">
                  <i class="fa-solid fa-circle-check text-brand text-xs"></i>
                  <span>SLA & NDA contracts signed prior to build</span>
                </div>
              </div>

              <!-- Action Buttons -->
              <div class="space-y-3">
                <Link
                  href="/contact"
                  class="w-full flex items-center justify-center gap-2 py-3.5 px-4 bg-brand hover:bg-brand-hover text-white rounded-xl text-xs font-bold uppercase tracking-wider transition shadow-lg shadow-brand/25"
                >
                  <span>Book Free Consultation</span>
                  <i class="fa-solid fa-arrow-right text-[11px]"></i>
                </Link>

                <a
                  href="tel:+8801742126262"
                  class="w-full flex items-center justify-center gap-2 py-3 px-4 bg-white/10 hover:bg-white/15 text-white border border-white/10 rounded-xl text-xs font-semibold transition"
                >
                  <i class="fa-solid fa-phone text-xs text-brand"></i>
                  <span>+880 1742-126262</span>
                </a>
              </div>

              <!-- Speed Guarantee -->
              <p class="text-[11px] text-slate-400 text-center mt-4">
                ⚡ Typical response time: <span class="text-slate-200 font-medium">Under 2 hours</span>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  faqs: {
    type: Array,
    default: () => [],
  },
});

const openIndex = ref(0);
const searchQuery = ref('');
const activeCategory = ref('All Topics');
const helpfulState = ref({});

const categories = [
  'All Topics',
  'Architecture & Stack',
  'Delivery & Timeline',
  'Security & IP Rights',
];

const toggleFaq = (index) => {
  openIndex.value = openIndex.value === index ? -1 : index;
};

const markHelpful = (index) => {
  helpfulState.value[index] = true;
};

const filteredFaqs = computed(() => {
  let list = props.faqs || [];

  // Filter by category
  if (activeCategory.value === 'Architecture & Stack') {
    list = list.filter((f) => {
      const text = ((f.q || f.question) + ' ' + (f.a || f.answer)).toLowerCase();
      return text.includes('technolog') || text.includes('laravel') || text.includes('vue') || text.includes('responsive');
    });
  } else if (activeCategory.value === 'Delivery & Timeline') {
    list = list.filter((f) => {
      const text = ((f.q || f.question) + ' ' + (f.a || f.answer)).toLowerCase();
      return text.includes('time') || text.includes('deliver') || text.includes('maintenance') || text.includes('support');
    });
  } else if (activeCategory.value === 'Security & IP Rights') {
    list = list.filter((f) => {
      const text = ((f.q || f.question) + ' ' + (f.a || f.answer)).toLowerCase();
      return text.includes('security') || text.includes('backup') || text.includes('ownership') || text.includes('payment') || text.includes('intellectual');
    });
  }

  // Filter by search query
  if (searchQuery.value.trim()) {
    const q = searchQuery.value.toLowerCase();
    list = list.filter((f) => {
      const question = (f.q || f.question || '').toLowerCase();
      const answer = (f.a || f.answer || '').toLowerCase();
      return question.includes(q) || answer.includes(q);
    });
  }

  return list;
});
</script>

<style scoped>
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-4px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
.animate-fadeIn {
  animation: fadeIn 0.25s ease-out forwards;
}
</style>
