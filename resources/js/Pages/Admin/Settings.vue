<template>
  <AdminLayout title="Global Site Settings" subtitle="Configure organization details, WhatsApp widget, and social channels">
    <Head title="Site Settings | SoftPolli Admin" />

    <!-- Top Toolbar -->
    <div class="bg-white border border-slate-200 shadow-sm dark:bg-slate-900 dark:border-slate-800 rounded-3xl p-6 mb-8 flex flex-wrap items-center justify-between gap-6 transition">
      <div class="flex items-center gap-5">
        <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-brand to-orange-400 text-white font-extrabold text-xl grid place-items-center shadow-lg shadow-brand/20 shrink-0">
          <i class="fa-solid fa-sliders"></i>
        </div>
        <div>
          <div class="flex items-center gap-2.5 flex-wrap">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Organization & Site Settings</h2>
            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-brand/10 text-brand border border-brand/20">
              Live Configuration
            </span>
          </div>
          <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
            Updates to these settings propagate immediately across the public website and footer.
          </p>
        </div>
      </div>

      <div class="flex items-center gap-3">
        <button
          type="button"
          @click="saveSettings"
          :disabled="form.processing"
          class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-brand hover:bg-brand-light text-white text-xs font-bold transition shadow-md shadow-brand/25 disabled:opacity-50"
        >
          <i class="fa-solid" :class="form.processing ? 'fa-spinner fa-spin' : 'fa-floppy-disk'"></i>
          <span>{{ form.processing ? 'Saving Changes...' : 'Save Settings' }}</span>
        </button>
      </div>
    </div>

    <!-- Tab Navigation -->
    <div class="flex items-center gap-2 border-b border-slate-200 dark:border-slate-800 mb-8 overflow-x-auto pb-px">
      <button
        @click="activeTab = 'general'"
        class="flex items-center gap-2 px-5 py-3 border-b-2 text-xs font-bold transition whitespace-nowrap"
        :class="activeTab === 'general' ? 'border-brand text-brand' : 'border-transparent text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white'"
      >
        <i class="fa-solid fa-building"></i>
        <span>General & Contact Info</span>
      </button>

      <button
        @click="activeTab = 'whatsapp'"
        class="flex items-center gap-2 px-5 py-3 border-b-2 text-xs font-bold transition whitespace-nowrap"
        :class="activeTab === 'whatsapp' ? 'border-brand text-brand' : 'border-transparent text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white'"
      >
        <i class="fa-brands fa-whatsapp text-emerald-500"></i>
        <span>Floating WhatsApp Widget</span>
        <span
          class="w-2 h-2 rounded-full"
          :class="form.settings.whatsapp_enabled === '1' || form.settings.whatsapp_enabled === true ? 'bg-emerald-500' : 'bg-slate-300 dark:bg-slate-600'"
        ></span>
      </button>

      <button
        @click="activeTab = 'social'"
        class="flex items-center gap-2 px-5 py-3 border-b-2 text-xs font-bold transition whitespace-nowrap"
        :class="activeTab === 'social' ? 'border-brand text-brand' : 'border-transparent text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white'"
      >
        <i class="fa-solid fa-share-nodes"></i>
        <span>Social Profiles</span>
      </button>
    </div>

    <!-- Form & Panels -->
    <form @submit.prevent="saveSettings">
      <!-- ============ TAB 1: GENERAL ============ -->
      <div v-show="activeTab === 'general'" class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white border border-slate-200 shadow-sm dark:bg-slate-900 dark:border-slate-800 rounded-3xl p-6 sm:p-8 space-y-6">
          <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2 border-b border-slate-100 dark:border-slate-800/80 pb-4">
            <i class="fa-solid fa-id-card text-brand"></i> Brand Identity
          </h3>

          <div>
            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
              Site / Brand Name
            </label>
            <input
              v-model="form.settings.site_name"
              type="text"
              class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
              placeholder="e.g. SoftPolli"
            />
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
              Brand Tagline / Slogan
            </label>
            <input
              v-model="form.settings.site_tagline"
              type="text"
              class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
              placeholder="e.g. Smart Software Solutions For Modern Businesses"
            />
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
              Business Working Hours
            </label>
            <input
              v-model="form.settings.business_hours"
              type="text"
              class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
              placeholder="e.g. Sat to Thursday: 8:00 am - 7:00 pm"
            />
          </div>
        </div>

        <div class="bg-white border border-slate-200 shadow-sm dark:bg-slate-900 dark:border-slate-800 rounded-3xl p-6 sm:p-8 space-y-6">
          <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2 border-b border-slate-100 dark:border-slate-800/80 pb-4">
            <i class="fa-solid fa-address-book text-brand"></i> Direct Contact & Office Details
          </h3>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                Primary Contact Email
              </label>
              <input
                v-model="form.settings.contact_email"
                type="email"
                class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
                placeholder="info@softpolli.com"
              />
            </div>
            <div>
              <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                Support / Billing Email
              </label>
              <input
                v-model="form.settings.support_email"
                type="email"
                class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
                placeholder="support@softpolli.com"
              />
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                Primary Phone Number
              </label>
              <input
                v-model="form.settings.contact_phone"
                type="text"
                class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
                placeholder="+880 1711-000000"
              />
            </div>
            <div>
              <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                Secondary Hotline / Mobile
              </label>
              <input
                v-model="form.settings.contact_phone_secondary"
                type="text"
                class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
                placeholder="+880 1800-000000"
              />
            </div>
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
              Physical Office Address
            </label>
            <textarea
              v-model="form.settings.office_address"
              rows="2"
              class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm leading-relaxed"
              placeholder="e.g. 2B/4 Ring Road, Shyamoli, Dhaka - 1207"
            ></textarea>
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
              Google Maps Location Link (Optional)
            </label>
            <input
              v-model="form.settings.google_maps_url"
              type="url"
              class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
              placeholder="https://maps.google.com/?q=..."
            />
          </div>
        </div>
      </div>

      <!-- ============ TAB 2: WHATSAPP ============ -->
      <div v-show="activeTab === 'whatsapp'" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Configuration Form (7 cols) -->
        <div class="lg:col-span-7 bg-white border border-slate-200 shadow-sm dark:bg-slate-900 dark:border-slate-800 rounded-3xl p-6 sm:p-8 space-y-6">
          <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800/80 pb-4">
            <div>
              <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <i class="fa-brands fa-whatsapp text-emerald-500 text-lg"></i> WhatsApp Quick Chat
              </h3>
              <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                Enable direct one-click WhatsApp messaging for prospective clients.
              </p>
            </div>
            <!-- Toggle Switch -->
            <label class="relative inline-flex items-center cursor-pointer">
              <input
                type="checkbox"
                v-model="whatsappEnabledBool"
                class="sr-only peer"
              />
              <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
            </label>
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">
              WhatsApp Phone Number <span class="text-red-500">*</span>
            </label>
            <p class="text-[11px] text-slate-400 mb-2">
              Enter with international country code, with no symbols, pluses, or dashes (e.g. <span class="font-mono text-emerald-600 dark:text-emerald-400 font-bold">8801700000000</span>).
            </p>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-xs">
                <i class="fa-solid fa-phone"></i>
              </div>
              <input
                v-model="form.settings.whatsapp_number"
                type="text"
                class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl pl-9 pr-4 py-2.5 text-xs text-slate-900 dark:text-white font-mono focus:outline-none focus:border-emerald-500 shadow-sm"
                placeholder="8801700000000"
              />
            </div>
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
              Agent / Team Name
            </label>
            <input
              v-model="form.settings.whatsapp_agent_name"
              type="text"
              class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500 shadow-sm"
              placeholder="e.g. SoftPolli Solutions Team"
            />
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
              Greeting Speech Bubble (Card Text)
            </label>
            <textarea
              v-model="form.settings.whatsapp_welcome_message"
              rows="2"
              class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500 shadow-sm leading-relaxed"
              placeholder="e.g. Hello! How can we assist with your software project today?"
            ></textarea>
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
              Default Pre-filled Client Message
            </label>
            <textarea
              v-model="form.settings.whatsapp_default_message"
              rows="3"
              class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500 shadow-sm leading-relaxed"
              placeholder="e.g. Hello SoftPolli team, I am interested in discussing a software project."
            ></textarea>
          </div>
        </div>

        <!-- Live Widget Preview (5 cols) -->
        <div class="lg:col-span-5 flex flex-col justify-between">
          <div class="bg-gradient-to-b from-slate-100 to-slate-200/80 dark:from-slate-900 dark:to-slate-950 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-8 flex flex-col items-center justify-center min-h-[440px] relative overflow-hidden">
            <span class="absolute top-4 left-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest flex items-center gap-1.5">
              <i class="fa-solid fa-eye"></i> Live Widget Mockup
            </span>

            <!-- Mock Chat Card -->
            <div class="w-full max-w-sm bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200/80 dark:border-slate-800 overflow-hidden mb-6">
              <!-- Header -->
              <div class="bg-[#075E54] text-white p-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-white/20 grid place-items-center text-white text-lg">
                  <i class="fa-brands fa-whatsapp"></i>
                </div>
                <div>
                  <h4 class="font-bold text-xs text-white">{{ form.settings.whatsapp_agent_name || 'SoftPolli Solutions' }}</h4>
                  <p class="text-[10px] text-emerald-200 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-300 animate-ping"></span>
                    Typically replies in 10 mins
                  </p>
                </div>
              </div>

              <!-- Message Bubble -->
              <div class="p-4 bg-[#E5DDD5] dark:bg-slate-950/60 min-h-[110px] flex items-start">
                <div class="bg-white dark:bg-slate-800 p-3 rounded-2xl rounded-tl-none shadow-sm text-xs text-slate-700 dark:text-slate-200 max-w-[85%] leading-relaxed">
                  {{ form.settings.whatsapp_welcome_message || 'Hello! How can we assist with your software project today?' }}
                </div>
              </div>

              <!-- Footer CTA -->
              <div class="p-3 bg-white dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <span class="text-[11px] text-slate-400 font-medium">Click to chat directly</span>
                <span class="inline-flex items-center gap-1.5 bg-[#25D366] text-white font-bold text-[11px] px-3.5 py-1.5 rounded-full shadow-sm">
                  <i class="fa-brands fa-whatsapp"></i> Chat Now
                </span>
              </div>
            </div>

            <!-- Floating Button Trigger Preview -->
            <div class="flex items-center gap-3 self-end pr-2">
              <span class="bg-white dark:bg-slate-800 text-[11px] font-bold text-slate-700 dark:text-slate-200 px-3 py-1.5 rounded-full shadow border border-slate-200/60 dark:border-slate-700">
                Chat on WhatsApp
              </span>
              <div class="w-12 h-12 rounded-full bg-[#25D366] text-white grid place-items-center text-xl shadow-lg shadow-emerald-500/30">
                <i class="fa-brands fa-whatsapp"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ============ TAB 3: SOCIAL ============ -->
      <div v-show="activeTab === 'social'" class="bg-white border border-slate-200 shadow-sm dark:bg-slate-900 dark:border-slate-800 rounded-3xl p-6 sm:p-8 space-y-6">
        <div class="border-b border-slate-100 dark:border-slate-800/80 pb-4">
          <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
            <i class="fa-solid fa-share-nodes text-brand"></i> Social Media & Corporate Channels
          </h3>
          <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
            These links appear in the website header, footer, and inquiry points.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
              <i class="fa-brands fa-facebook-f text-blue-600 mr-1.5"></i> Facebook Page URL
            </label>
            <input
              v-model="form.settings.social_facebook"
              type="url"
              class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
              placeholder="https://facebook.com/your-page"
            />
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
              <i class="fa-brands fa-linkedin-in text-sky-600 mr-1.5"></i> LinkedIn Company URL
            </label>
            <input
              v-model="form.settings.social_linkedin"
              type="url"
              class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
              placeholder="https://linkedin.com/company/your-company"
            />
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
              <i class="fa-brands fa-x-twitter text-slate-800 dark:text-white mr-1.5"></i> X / Twitter URL
            </label>
            <input
              v-model="form.settings.social_twitter"
              type="url"
              class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
              placeholder="https://twitter.com/your-handle"
            />
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
              <i class="fa-brands fa-github text-slate-800 dark:text-white mr-1.5"></i> GitHub Organization URL
            </label>
            <input
              v-model="form.settings.social_github"
              type="url"
              class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
              placeholder="https://github.com/your-org"
            />
          </div>
        </div>
      </div>

      <!-- Bottom Save Action Bar -->
      <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between">
        <p class="text-xs text-slate-500 dark:text-slate-400">
          Ensure all phone numbers and links are valid before saving.
        </p>
        <button
          type="submit"
          :disabled="form.processing"
          class="inline-flex items-center gap-2 px-7 py-3 rounded-xl bg-brand hover:bg-brand-light text-white text-xs font-bold transition shadow-md shadow-brand/25 disabled:opacity-50"
        >
          <i class="fa-solid" :class="form.processing ? 'fa-spinner fa-spin' : 'fa-floppy-disk'"></i>
          <span>{{ form.processing ? 'Saving Changes...' : 'Save Settings' }}</span>
        </button>
      </div>
    </form>
  </AdminLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
  settings: {
    type: Array,
    default: () => [],
  },
  groupedSettings: {
    type: Object,
    default: () => ({}),
  },
});

const activeTab = ref('general');

// Map array of setting objects to reactive dictionary
const initialSettings = {};
props.settings.forEach((s) => {
  initialSettings[s.key] = s.value;
});

const form = useForm({
  settings: {
    site_name: initialSettings.site_name ?? 'SoftPolli',
    site_tagline: initialSettings.site_tagline ?? 'Smart Software Solutions For Modern Businesses',
    contact_email: initialSettings.contact_email ?? 'info@softpolli.com',
    support_email: initialSettings.support_email ?? 'support@softpolli.com',
    contact_phone: initialSettings.contact_phone ?? '+880 1711-000000',
    contact_phone_secondary: initialSettings.contact_phone_secondary ?? '+880 1800-000000',
    office_address: initialSettings.office_address ?? '2B/4 Ring Road, Shyamoli, Dhaka - 1207',
    business_hours: initialSettings.business_hours ?? 'Sat to Thursday: 8:00 am - 7:00 pm',
    google_maps_url: initialSettings.google_maps_url ?? 'https://maps.google.com/?q=2B/4+Ring+Road+Shyamoli+Dhaka',

    whatsapp_enabled: initialSettings.whatsapp_enabled ?? '1',
    whatsapp_number: initialSettings.whatsapp_number ?? '8801700000000',
    whatsapp_agent_name: initialSettings.whatsapp_agent_name ?? 'SoftPolli Solutions Team',
    whatsapp_welcome_message: initialSettings.whatsapp_welcome_message ?? 'Hello! How can we assist with your software project today?',
    whatsapp_default_message: initialSettings.whatsapp_default_message ?? 'Hello SoftPolli team, I am interested in discussing a software project.',

    social_facebook: initialSettings.social_facebook ?? 'https://facebook.com/softpolli',
    social_linkedin: initialSettings.social_linkedin ?? 'https://linkedin.com/company/softpolli',
    social_twitter: initialSettings.social_twitter ?? 'https://twitter.com/softpolli',
    social_github: initialSettings.social_github ?? 'https://github.com/softpolli',
  },
});

const whatsappEnabledBool = computed({
  get: () => form.settings.whatsapp_enabled === '1' || form.settings.whatsapp_enabled === true,
  set: (val) => {
    form.settings.whatsapp_enabled = val ? '1' : '0';
  },
});

const saveSettings = () => {
  form.put('/admin/settings', {
    preserveScroll: true,
  });
};
</script>

