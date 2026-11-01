<template>
  <div class="min-h-screen bg-navy-950 flex flex-col justify-center items-center p-6 text-slate-100 font-sans selection:bg-brand selection:text-white relative overflow-hidden">
    <!-- Subtle Background Glow -->
    <div class="absolute w-[500px] h-[500px] rounded-full bg-brand/10 blur-[120px] pointer-events-none top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"></div>

    <div class="w-full max-w-md relative z-10">
      <!-- Brand Logo Header -->
      <div class="text-center mb-8">
        <Link href="/" class="inline-flex items-center gap-3 mb-4">
          <img src="/images/SP-logo.png" alt="SoftPolli" class="w-12 h-12 rounded-2xl shadow-xl border border-white/10" />
        </Link>
        <h1 class="text-2xl font-extrabold text-white">SoftPolli Admin Portal</h1>
        <p class="text-xs text-slate-400 mt-1">Sign in to manage inquiries, quotes, and web content</p>
      </div>

      <!-- Login Card -->
      <div class="bg-slate-900/90 backdrop-blur-xl border border-slate-800 rounded-3xl p-8 shadow-2xl">
        <!-- Error Alert -->
        <div v-if="form.errors.email || form.errors.password" class="mb-5 p-3.5 rounded-xl bg-red-500/15 border border-red-500/30 text-red-400 text-xs flex items-center gap-2">
          <i class="fa-solid fa-circle-exclamation shrink-0"></i>
          <span>{{ form.errors.email || form.errors.password }}</span>
        </div>

        <form @submit.prevent="submit" class="space-y-5 text-xs">
          <div>
            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Admin Email</label>
            <input
              v-model="form.email"
              type="email"
              required
              autofocus
              placeholder="admin@softpolli.com"
              class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3.5 text-white placeholder-slate-500 focus:outline-none focus:border-brand transition"
            />
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Password</label>
            <input
              v-model="form.password"
              type="password"
              required
              placeholder="••••••••"
              class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3.5 text-white placeholder-slate-500 focus:outline-none focus:border-brand transition"
            />
          </div>

          <div class="flex items-center justify-between text-xs text-slate-400">
            <label class="flex items-center gap-2 cursor-pointer select-none">
              <input v-model="form.remember" type="checkbox" class="w-4 h-4 text-brand rounded border-slate-700 bg-slate-950 focus:ring-brand" />
              <span>Remember me</span>
            </label>
          </div>

          <button
            type="submit"
            :disabled="form.processing"
            class="w-full py-4 rounded-xl bg-brand hover:bg-brand-light text-white font-bold text-xs uppercase tracking-wider transition shadow-lg shadow-brand/25 disabled:opacity-50 cursor-pointer"
          >
            <span v-if="form.processing"><i class="fa-solid fa-circle-notch fa-spin mr-1"></i> Authenticating...</span>
            <span v-else>Access Admin Dashboard <i class="fa-solid fa-arrow-right ml-1"></i></span>
          </button>
        </form>

        <!-- Default Credentials Helper -->
        <div class="mt-8 pt-6 border-t border-slate-800/80 text-[11px] text-slate-400">
          <p class="font-bold text-slate-300 mb-1 flex items-center gap-1.5">
            <i class="fa-solid fa-key text-brand text-[10px]"></i> Default Credentials:
          </p>
          <div class="bg-slate-950 p-3 rounded-xl border border-slate-800 font-mono text-[10px] space-y-1">
            <p><span class="text-slate-500">Email:</span> <span class="text-white select-all">admin@softpolli.com</span></p>
            <p><span class="text-slate-500">Password:</span> <span class="text-brand select-all">admin123</span></p>
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
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
  email: 'admin@softpolli.com',
  password: 'admin123',
  remember: false,
});

function submit() {
  form.post('/admin/login', {
    onSuccess: () => {
      window.location.href = '/admin/dashboard';
    },
    onFinish: () => form.reset('password'),
  });
}
</script>
