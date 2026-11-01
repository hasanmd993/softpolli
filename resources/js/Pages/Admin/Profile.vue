<template>
  <AdminLayout title="Admin Profile & Security" subtitle="Manage your administrative credentials and security settings">
    <Head title="Admin Profile | SoftPolli Admin" />

    <!-- Top Profile Banner Toolbar (Matches Services & Inquiries toolbars) -->
    <div class="bg-white border border-slate-200 shadow-sm dark:bg-slate-900 dark:border-slate-800 rounded-3xl p-6 mb-8 flex flex-wrap items-center justify-between gap-6 transition">
      <div class="flex items-center gap-5">
        <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-brand to-orange-400 text-white font-extrabold text-xl grid place-items-center shadow-lg shadow-brand/20 shrink-0">
          {{ userInitial }}
        </div>
        <div>
          <div class="flex items-center gap-2.5 flex-wrap">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">{{ user?.name || 'Administrator' }}</h2>
            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-brand/10 text-brand border border-brand/20">
              Super Admin
            </span>
            <span class="inline-flex items-center gap-1.5 text-[11px] text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 px-2.5 py-0.5 rounded-full font-semibold">
              <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 dark:bg-emerald-400 animate-pulse"></span>
              Active
            </span>
          </div>
          <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ user?.email }}</p>
          <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1 flex items-center gap-1.5">
            <i class="fa-solid fa-shield-halved text-brand"></i> Protected system administrative account
          </p>
        </div>
      </div>

      <div class="flex items-center gap-3">
        <a
          href="/"
          target="_blank"
          class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700/60 bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-200 hover:text-brand dark:hover:text-brand text-xs font-semibold transition flex items-center gap-2 shadow-sm"
        >
          <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
          <span>Live Site</span>
        </a>
      </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Left Column: Change Password Form (2 cols wide) -->
      <div class="lg:col-span-2 space-y-8">
        <div class="bg-white border border-slate-200 shadow-sm dark:bg-slate-900 dark:border-slate-800 rounded-3xl p-6 sm:p-8 transition">
          <div class="flex items-center justify-between pb-6 mb-6 border-b border-slate-100 dark:border-slate-800/80">
            <div>
              <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <i class="fa-solid fa-key text-brand"></i> Change Password
              </h3>
              <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                Update your administrative credentials to ensure high security.
              </p>
            </div>
            <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider bg-slate-100 dark:bg-slate-800 px-3 py-1 rounded-lg">
              Security
            </span>
          </div>

          <form @submit.prevent="submitPassword" class="space-y-6">
            <!-- Current Password -->
            <div>
              <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                Current Password <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <input
                  v-model="passwordForm.current_password"
                  :type="showCurrent ? 'text' : 'password'"
                  class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:border-brand shadow-sm pr-11"
                  placeholder="Enter your current password"
                  required
                />
                <button
                  type="button"
                  @click="showCurrent = !showCurrent"
                  class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition text-xs"
                >
                  <i :class="showCurrent ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                </button>
              </div>
              <p v-if="passwordForm.errors.current_password" class="text-xs text-red-500 font-semibold mt-1.5">
                {{ passwordForm.errors.current_password }}
              </p>
            </div>

            <!-- New Password & Confirmation Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
              <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                  New Password <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                  <input
                    v-model="passwordForm.password"
                    :type="showNew ? 'text' : 'password'"
                    class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:border-brand shadow-sm pr-11"
                    placeholder="Min 8 characters"
                    required
                  />
                  <button
                    type="button"
                    @click="showNew = !showNew"
                    class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition text-xs"
                  >
                    <i :class="showNew ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                  </button>
                </div>
                <p v-if="passwordForm.errors.password" class="text-xs text-red-500 font-semibold mt-1.5">
                  {{ passwordForm.errors.password }}
                </p>
              </div>

              <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                  Confirm New Password <span class="text-red-500">*</span>
                </label>
                <input
                  v-model="passwordForm.password_confirmation"
                  type="password"
                  class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:border-brand shadow-sm"
                  placeholder="Repeat new password"
                  required
                />
              </div>
            </div>

            <!-- Actions -->
            <div class="pt-4 flex items-center justify-end border-t border-slate-100 dark:border-slate-800/80">
              <button
                type="submit"
                :disabled="passwordForm.processing"
                class="px-5 py-2.5 rounded-xl bg-brand hover:bg-brand-hover text-white text-xs font-bold transition flex items-center justify-center gap-2 shadow-lg shadow-brand/20 disabled:opacity-50"
              >
                <i v-if="passwordForm.processing" class="fa-solid fa-circle-notch fa-spin text-xs"></i>
                <i v-else class="fa-solid fa-check text-xs"></i>
                <span>Update Password</span>
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Right Column: Account Details & Guidelines (1 col wide) -->
      <div class="lg:col-span-1 space-y-6">
        <!-- Account Overview Card -->
        <div class="bg-white border border-slate-200 shadow-sm dark:bg-slate-900 dark:border-slate-800 rounded-3xl p-6 transition">
          <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-user-shield text-brand"></i> Authority & Scope
          </h4>

          <div class="space-y-3.5 text-xs">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800/80">
              <span class="text-slate-500 dark:text-slate-400">Account Type</span>
              <span class="font-bold text-slate-900 dark:text-white">Super Administrator</span>
            </div>
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800/80">
              <span class="text-slate-500 dark:text-slate-400">System Scope</span>
              <span class="font-bold text-slate-900 dark:text-white">All 8 Dynamic Modules</span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-slate-500 dark:text-slate-400">Session Auth</span>
              <span class="font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-1">
                <i class="fa-solid fa-lock text-[10px]"></i> Encrypted
              </span>
            </div>
          </div>
        </div>

        <!-- Password Guidelines Card -->
        <div class="bg-white border border-slate-200 shadow-sm dark:bg-slate-900 dark:border-slate-800 rounded-3xl p-6 transition">
          <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-circle-info text-blue-500"></i> Password Tips
          </h4>

          <ul class="space-y-2.5 text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
            <li class="flex items-start gap-2">
              <i class="fa-solid fa-check text-emerald-500 text-[10px] mt-1 shrink-0"></i>
              <span>Use at least 8 characters with a mix of numbers and letters.</span>
            </li>
            <li class="flex items-start gap-2">
              <i class="fa-solid fa-check text-emerald-500 text-[10px] mt-1 shrink-0"></i>
              <span>Never reuse passwords from personal or external accounts.</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { computed, ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
  user: Object,
});

const userInitial = computed(() => {
  return props.user?.name ? props.user.name.charAt(0).toUpperCase() : 'A';
});

const showCurrent = ref(false);
const showNew = ref(false);

const passwordForm = useForm({
  current_password: '',
  password: '',
  password_confirmation: '',
});

const submitPassword = () => {
  passwordForm.put('/admin/profile/password', {
    preserveScroll: true,
    onSuccess: () => {
      passwordForm.reset();
    },
  });
};
</script>
