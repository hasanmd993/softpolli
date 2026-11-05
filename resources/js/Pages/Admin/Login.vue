<template>
  <div class="min-h-screen bg-navy-950 flex flex-col justify-center items-center p-6 text-slate-100 font-sans selection:bg-brand selection:text-white relative overflow-hidden">
    <Head title="Admin Login | SoftPolli" />

    <!-- Subtle Background Glow -->
    <div class="absolute w-[500px] h-[500px] rounded-full bg-brand/10 blur-[120px] pointer-events-none top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute w-[400px] h-[400px] rounded-full bg-emerald-500/5 blur-[100px] pointer-events-none -bottom-20 -right-20"></div>

    <div class="w-full max-w-md relative z-10">
      <!-- Brand Logo Header -->
      <div class="text-center mb-8">
        <Link href="/" class="inline-flex items-center gap-3 mb-4">
          <img src="/images/SP-logo.png" alt="SoftPolli" class="w-12 h-12 rounded-2xl shadow-xl border border-white/10" />
        </Link>
        <h1 class="text-2xl font-extrabold text-white">SoftPolli Admin Portal</h1>
        <p class="text-xs text-slate-400 mt-1">Sign in with role-based credentials to manage operations</p>
      </div>

      <!-- Login Card -->
      <div class="bg-slate-900/90 backdrop-blur-xl border border-slate-800 rounded-3xl p-8 shadow-2xl">
        <!-- Error Alert -->
        <div v-if="form.errors.email || form.errors.password" class="mb-5 p-3.5 rounded-xl bg-red-500/15 border border-red-500/30 text-red-400 text-xs flex items-center gap-2">
          <i class="fa-solid fa-circle-exclamation shrink-0"></i>
          <span>{{ form.errors.email || form.errors.password }}</span>
        </div>

        <form @submit.prevent="submit" class="space-y-5 text-xs">
          <!-- Email -->
          <div>
            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Admin Email</label>
            <div class="relative">
              <i class="fa-regular fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-500 text-xs"></i>
              <input
                v-model="form.email"
                type="email"
                required
                autofocus
                class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-9 pr-4 py-3.5 text-white focus:outline-none focus:border-brand transition"
              />
            </div>
          </div>

          <!-- Password -->
          <div>
            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Password</label>
            <div class="relative">
              <i class="fa-solid fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-500 text-xs"></i>
              <input
                v-model="form.password"
                type="password"
                required
                class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-9 pr-4 py-3.5 text-white focus:outline-none focus:border-brand transition"
              />
            </div>
          </div>

          <!-- CAPTCHA Security Verification Box -->
          <div class="p-4 rounded-2xl bg-slate-950 border border-slate-800 space-y-3">
            <div class="flex items-center justify-between text-slate-300">
              <label class="font-bold uppercase tracking-wider text-[11px] flex items-center gap-1.5 text-slate-300">
                <i class="fa-solid fa-shield-halved text-brand text-xs"></i>
                <span>Security Captcha</span>
              </label>

              <!-- Refresh Button -->
              <button
                type="button"
                @click="refreshCaptcha"
                :disabled="isRefreshingCaptcha"
                class="text-slate-400 hover:text-brand transition flex items-center gap-1 text-[11px] font-semibold"
                title="Generate a new security challenge"
              >
                <i class="fa-solid fa-rotate-right" :class="{ 'fa-spin': isRefreshingCaptcha }"></i>
                <span>Refresh</span>
              </button>
            </div>

            <!-- Challenge Row -->
            <div class="flex items-center gap-3">
              <!-- Visual Math Challenge Badge -->
              <div class="px-4 py-2.5 rounded-xl bg-navy-900 border border-slate-700/80 font-mono font-black text-sm text-brand-light tracking-widest select-none shadow-inner shrink-0">
                {{ currentQuestion }} = ?
              </div>

              <!-- Answer Input -->
              <div class="flex-1">
                <input
                  v-model="form.captcha_answer"
                  type="text"
                  required
                  autocomplete="off"
                  class="w-full bg-slate-900 border border-slate-800 rounded-xl px-3.5 py-2.5 text-white text-xs focus:outline-none focus:border-brand transition"
                />
              </div>
            </div>

            <!-- Captcha Error -->
            <div v-if="form.errors.captcha_answer" class="text-red-400 text-[11px] flex items-center gap-1 mt-1">
              <i class="fa-solid fa-circle-xmark"></i>
              <span>{{ form.errors.captcha_answer }}</span>
            </div>
          </div>

          <div class="flex items-center justify-between text-xs text-slate-400">
            <label class="flex items-center gap-2 cursor-pointer select-none">
              <input v-model="form.remember" type="checkbox" class="w-4 h-4 text-brand rounded border-slate-700 bg-slate-950 focus:ring-brand" />
              <span>Remember me</span>
            </label>
            <span class="text-[11px] text-slate-500 flex items-center gap-1">
              <i class="fa-solid fa-shield text-emerald-400 text-[9px]"></i> Rate Limiter Active
            </span>
          </div>

          <button
            type="submit"
            :disabled="form.processing"
            class="w-full py-4 rounded-xl bg-brand hover:bg-brand-light text-white font-bold text-xs uppercase tracking-wider transition shadow-lg shadow-brand/25 disabled:opacity-50 cursor-pointer active:scale-[0.99]"
          >
            <span v-if="form.processing"><i class="fa-solid fa-circle-notch fa-spin mr-1"></i> Authenticating...</span>
            <span v-else>Access Admin Dashboard <i class="fa-solid fa-arrow-right ml-1"></i></span>
          </button>
        </form>

        <!-- Click to Show Credentials & Copy Section -->
        <div class="mt-8 pt-6 border-t border-slate-800/80">
          <button
            type="button"
            @click="showCredentials = !showCredentials"
            class="w-full py-2.5 px-3 rounded-xl bg-slate-950 hover:bg-slate-800/80 border border-slate-800 text-slate-400 hover:text-white transition flex items-center justify-between text-xs font-semibold"
          >
            <span class="flex items-center gap-2">
              <i class="fa-solid fa-key text-brand text-xs"></i>
              <span>Demo Credentials</span>
            </span>
            <span class="flex items-center gap-1 text-[11px] text-slate-400">
              <span>{{ showCredentials ? 'Hide' : 'Click to show' }}</span>
              <i class="fa-solid text-[10px] transition-transform duration-200" :class="showCredentials ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </span>
          </button>

          <!-- Collapsible Credentials Drawer -->
          <div v-if="showCredentials" class="mt-3 p-4 rounded-2xl bg-slate-950 border border-slate-800/90 space-y-3 animate-fade-in text-xs">
            <!-- Email Row -->
            <div class="flex items-center justify-between gap-2 p-2 rounded-xl bg-slate-900 border border-slate-800">
              <div class="truncate">
                <span class="text-[10px] uppercase font-bold text-slate-500 block">Email</span>
                <span class="font-mono text-white text-[11px] font-semibold select-all">admin@softpolli.com</span>
              </div>
              <button
                type="button"
                @click="copyText('admin@softpolli.com', 'email')"
                class="px-2.5 py-1.5 rounded-lg bg-slate-800 hover:bg-brand text-slate-300 hover:text-white transition text-[10px] font-bold flex items-center gap-1.5 shrink-0"
              >
                <i :class="copiedField === 'email' ? 'fa-solid fa-check text-emerald-400' : 'fa-regular fa-copy'"></i>
                <span>{{ copiedField === 'email' ? 'Copied!' : 'Copy' }}</span>
              </button>
            </div>

            <!-- Password Row -->
            <div class="flex items-center justify-between gap-2 p-2 rounded-xl bg-slate-900 border border-slate-800">
              <div class="truncate">
                <span class="text-[10px] uppercase font-bold text-slate-500 block">Password</span>
                <span class="font-mono text-brand font-bold text-[11px] select-all">admin123</span>
              </div>
              <button
                type="button"
                @click="copyText('admin123', 'password')"
                class="px-2.5 py-1.5 rounded-lg bg-slate-800 hover:bg-brand text-slate-300 hover:text-white transition text-[10px] font-bold flex items-center gap-1.5 shrink-0"
              >
                <i :class="copiedField === 'password' ? 'fa-solid fa-check text-emerald-400' : 'fa-regular fa-copy'"></i>
                <span>{{ copiedField === 'password' ? 'Copied!' : 'Copy' }}</span>
              </button>
            </div>

            <!-- Auto-Fill Form 1-Click Action -->
            <button
              type="button"
              @click="autoFill"
              class="w-full py-2 rounded-xl bg-brand/10 hover:bg-brand text-brand hover:text-white font-bold transition text-xs flex items-center justify-center gap-1.5 border border-brand/20 shadow-xs"
            >
              <i :class="copiedField === 'autofill' ? 'fa-solid fa-check text-emerald-400' : 'fa-solid fa-wand-magic-sparkles'"></i>
              <span>{{ copiedField === 'autofill' ? 'Credentials Populated!' : '1-Click Auto Fill Form' }}</span>
            </button>
          </div>
        </div>
      </div>

      <div class="text-center mt-6">
        <Link href="/" class="text-xs text-slate-400 hover:text-white transition inline-flex items-center gap-1">
          <i class="fa-solid fa-arrow-left text-[10px]"></i> Return to Public Site
        </Link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
  captcha: {
    type: Object,
    default: () => ({ question: '5 + 3', token: '' }),
  },
});

const currentQuestion = ref(props.captcha?.question || '5 + 3');
const currentToken = ref(props.captcha?.token || '');
const isRefreshingCaptcha = ref(false);
const showCredentials = ref(false);
const copiedField = ref(null);

const form = useForm({
  email: '',
  password: '',
  remember: false,
  captcha_answer: '',
  captcha_token: props.captcha?.token || '',
});

async function copyText(text, fieldName) {
  try {
    if (navigator?.clipboard?.writeText) {
      await navigator.clipboard.writeText(text);
    } else {
      // Fallback for older browsers
      const textArea = document.createElement('textarea');
      textArea.value = text;
      document.body.appendChild(textArea);
      textArea.select();
      document.execCommand('copy');
      document.body.removeChild(textArea);
    }
    copiedField.value = fieldName;
    setTimeout(() => {
      if (copiedField.value === fieldName) {
        copiedField.value = null;
      }
    }, 2000);
  } catch (err) {
    console.error('Failed to copy credentials', err);
  }
}

function autoFill() {
  form.email = 'admin@softpolli.com';
  form.password = 'admin123';
  copiedField.value = 'autofill';
  setTimeout(() => {
    if (copiedField.value === 'autofill') {
      copiedField.value = null;
    }
  }, 2000);
}

async function refreshCaptcha() {
  isRefreshingCaptcha.value = true;
  try {
    const res = await fetch('/admin/captcha/refresh');
    if (res.ok) {
      const data = await res.json();
      currentQuestion.value = data.question;
      currentToken.value = data.token;
      form.captcha_token = data.token;
      form.captcha_answer = '';
    }
  } catch (err) {
    console.error('Failed to refresh security captcha', err);
  } finally {
    isRefreshingCaptcha.value = false;
  }
}

function submit() {
  form.post('/admin/login', {
    onSuccess: () => {
      window.location.href = '/admin/dashboard';
    },
    onError: () => {
      refreshCaptcha();
    },
    onFinish: () => form.reset('password'),
  });
}
</script>
