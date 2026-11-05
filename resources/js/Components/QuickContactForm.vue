<template>
  <div class="bg-navy-900/90 backdrop-blur-xl text-white rounded-3xl p-6 sm:p-10 lg:p-12 shadow-2xl border border-slate-800 relative overflow-hidden">
    <!-- Ambient subtle corner glow -->
    <div class="absolute -top-20 -right-20 w-60 h-60 bg-brand/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative z-10">
      <div class="mb-8">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand/20 text-brand-light text-[11px] font-bold uppercase tracking-wider mb-2 border border-brand/30">
          <i class="fa-solid fa-paper-plane text-xs"></i> Direct Inquiry
        </span>
        <h3 class="text-2xl sm:text-3xl font-black text-white tracking-tight mt-1">
          Request a Technical Proposal
        </h3>
        <p class="text-xs sm:text-sm text-slate-400 mt-2 leading-relaxed">
          Tell us about your project requirements. An enterprise architect will review your scope and provide an actionable estimate within 2 hours.
        </p>
      </div>

      <!-- Success State -->
      <div v-if="submitted" class="p-8 rounded-2xl bg-brand/10 border border-brand/30 text-center animate-fade-in">
        <div class="w-14 h-14 bg-brand text-white rounded-2xl grid place-items-center mx-auto mb-4 text-2xl shadow-lg shadow-brand/30">
          <i class="fa-solid fa-check"></i>
        </div>
        <h4 class="text-lg font-bold text-white mb-2">Inquiry Received Successfully!</h4>
        <p class="text-xs text-slate-300 max-w-md mx-auto leading-relaxed mb-6">
          Thank you for reaching out to SoftPolli. Our engineering directors have received your brief and will connect via email or phone shortly.
        </p>
        <button
          @click="resetForm"
          class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-bold transition border border-white/10"
        >
          <i class="fa-solid fa-rotate-left"></i> Send Another Inquiry
        </button>
      </div>

      <!-- Form State -->
      <form v-else @submit.prevent="submit" class="space-y-5 text-xs">
        <!-- Hidden Honeypot for Anti-Spam Protection -->
        <input
          type="text"
          name="_honeypot"
          v-model="form._honeypot"
          class="hidden"
          tabindex="-1"
          autocomplete="off"
        />

        <!-- Name & Phone Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-slate-300 text-[11px] font-semibold mb-1.5">
              Your Name <span class="text-brand">*</span>
            </label>
            <div class="relative">
              <i class="fa-regular fa-user absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
              <input
                v-model="form.name"
                type="text"
                placeholder="e.g. Tanvir Ahmed"
                required
                class="w-full bg-navy-950/80 border border-slate-700/80 rounded-xl pl-9 pr-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition"
              />
            </div>
            <div v-if="form.errors.name" class="text-red-400 text-[11px] mt-1">{{ form.errors.name }}</div>
          </div>

          <div>
            <label class="block text-slate-300 text-[11px] font-semibold mb-1.5">
              Phone / WhatsApp
            </label>
            <div class="relative">
              <i class="fa-solid fa-phone absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
              <input
                v-model="form.phone"
                type="tel"
                placeholder="+880 1700-000000"
                class="w-full bg-navy-950/80 border border-slate-700/80 rounded-xl pl-9 pr-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition"
              />
            </div>
            <div v-if="form.errors.phone" class="text-red-400 text-[11px] mt-1">{{ form.errors.phone }}</div>
          </div>
        </div>

        <!-- Email Address -->
        <div>
          <label class="block text-slate-300 text-[11px] font-semibold mb-1.5">
            Work Email Address <span class="text-brand">*</span>
          </label>
          <div class="relative">
            <i class="fa-regular fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
            <input
              v-model="form.email"
              type="email"
              placeholder="e.g. tanvir@company.com"
              required
              class="w-full bg-navy-950/80 border border-slate-700/80 rounded-xl pl-9 pr-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition"
            />
          </div>
          <div v-if="form.errors.email" class="text-red-400 text-[11px] mt-1">{{ form.errors.email }}</div>
        </div>

        <!-- Subject / Solution Type -->
        <div>
          <label class="block text-slate-300 text-[11px] font-semibold mb-1.5">
            Service or Solution Required <span class="text-brand">*</span>
          </label>
          <div class="relative">
            <i class="fa-solid fa-layer-group absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
            <select
              v-model="form.subject"
              class="w-full bg-navy-950/80 border border-slate-700/80 rounded-xl pl-9 pr-10 py-3 text-slate-200 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition appearance-none cursor-pointer"
            >
              <option value="Custom Software Development">Custom Software Development</option>
              <option value="Enterprise ERP & Inventory Solution">Enterprise ERP & Inventory Solution</option>
              <option value="POS & Retail Billing System">POS & Retail Billing System</option>
              <option value="Hospital & Diagnostic ERP">Hospital & Diagnostic ERP</option>
              <option value="Restaurant & Hospitality Software">Restaurant & Hospitality Software</option>
              <option value="High-Performance E-Commerce & Portal">High-Performance E-Commerce & Portal</option>
              <option value="Mobile App Development (iOS & Android)">Mobile App Development (iOS & Android)</option>
              <option value="Cyber Security & Cloud Infrastructure Audit">Cyber Security & Cloud Infrastructure Audit</option>
              <option value="General Architecture Consultation">General Architecture Consultation</option>
            </select>
            <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
          </div>
        </div>

        <!-- Message / Project Scope -->
        <div>
          <label class="block text-slate-300 text-[11px] font-semibold mb-1.5">
            Project Overview or Key Requirements <span class="text-brand">*</span>
          </label>
          <textarea
            v-model="form.message"
            rows="4"
            placeholder="Tell us about your business goals, target timelines, or existing systems you wish to integrate..."
            required
            class="w-full bg-navy-950/80 border border-slate-700/80 rounded-xl p-3.5 text-white placeholder-slate-500 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition"
          ></textarea>
          <div v-if="form.errors.message" class="text-red-400 text-[11px] mt-1">{{ form.errors.message }}</div>
        </div>

        <!-- Submit Button & Trust Note -->
        <div>
          <button
            type="submit"
            :disabled="form.processing"
            class="w-full py-4 bg-brand hover:bg-brand-light text-white font-extrabold rounded-xl text-xs uppercase tracking-wider transition shadow-lg shadow-brand/25 disabled:opacity-50 active:scale-[0.99] flex items-center justify-center gap-2 cursor-pointer"
          >
            <span v-if="form.processing" class="flex items-center gap-2">
              <i class="fa-solid fa-circle-notch fa-spin"></i> Dispatching Inquiry...
            </span>
            <span v-else class="flex items-center gap-2">
              <span>Send Technical Inquiry</span>
              <i class="fa-solid fa-arrow-right"></i>
            </span>
          </button>

          <div class="flex items-center justify-center gap-4 mt-3 text-[11px] text-slate-400">
            <span class="flex items-center gap-1.5">
              <i class="fa-solid fa-shield-halved text-emerald-400"></i> NDA Protected
            </span>
            <span>&bull;</span>
            <span class="flex items-center gap-1.5">
              <i class="fa-solid fa-clock text-brand-light"></i> &lt; 2h Response Time
            </span>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import confetti from 'canvas-confetti';

const props = defineProps({
  initialSubject: {
    type: String,
    default: '',
  },
});

const page = usePage();
const submitted = ref(false);

const form = useForm({
  _token: page.props.csrf_token || '',
  _honeypot: '',
  name: '',
  phone: '',
  email: '',
  subject: props.initialSubject || 'Custom Software Development',
  message: '',
});

function cleanUrlParams() {
  if (typeof window !== 'undefined') {
    const url = new URL(window.location.href);
    const serviceParam = url.searchParams.get('service') || url.searchParams.get('solution');
    if (serviceParam) {
      form.subject = serviceParam;
    }
  }
}

onMounted(() => {
  cleanUrlParams();
});

function submit() {
  if (page.props.csrf_token) {
    form._token = page.props.csrf_token;
  }
  form.post('/contact', {
    preserveScroll: true,
    onSuccess: () => {
      submitted.value = true;
      try {
        confetti({
          particleCount: 80,
          spread: 70,
          origin: { y: 0.6 },
          colors: ['#0284c7', '#38bdf8', '#10b981', '#6366f1'],
        });
      } catch (e) {
        // Fallback gracefully if canvas context is unavailable
      }
      form.reset('name', 'phone', 'email', 'message', '_honeypot');
    },
  });
}

function resetForm() {
  submitted.value = false;
  form.reset();
}
</script>
