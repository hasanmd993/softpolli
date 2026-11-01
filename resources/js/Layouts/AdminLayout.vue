<template>
  <div :class="{ 'dark': isDark }" class="h-screen w-screen overflow-hidden flex bg-slate-100 text-slate-800 dark:bg-slate-900 dark:text-slate-100 font-sans transition-colors duration-200">
    <!-- Mobile Backdrop Overlay -->
    <div
      v-if="mobileSidebarOpen"
      @click="mobileSidebarOpen = false"
      class="fixed inset-0 bg-slate-900/60 dark:bg-slate-950/80 backdrop-blur-sm z-40 lg:hidden transition-opacity"
    ></div>

    <!-- Sidebar (Desktop docked & fixed in place, Mobile off-canvas drawer) -->
    <aside
      class="flex flex-col shrink-0 h-full overflow-hidden transition-all duration-300 z-50 fixed lg:static top-0 left-0 w-72 lg:w-64 bg-white border-r border-slate-200 text-slate-700 shadow-sm dark:bg-navy-950 dark:border-slate-800 dark:text-slate-200"
      :class="mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
    >
      <!-- Pinned Brand Header (Never scrolls away) -->
      <div class="h-16 flex items-center justify-between px-5 border-b border-slate-200 dark:border-slate-800/80 shrink-0 bg-white dark:bg-navy-950 transition-colors">
        <div class="flex items-center gap-3">
          <img src="/images/SP-logo.png" alt="SoftPolli" class="w-8 h-8 rounded-xl shadow" />
          <div>
            <h1 class="font-extrabold text-xs text-slate-900 dark:text-white tracking-wide">SoftPolli</h1>
            <p class="text-[9px] text-brand font-bold uppercase tracking-wider">Back-Office Admin</p>
          </div>
        </div>

        <!-- Mobile Close Button -->
        <button
          @click="mobileSidebarOpen = false"
          class="lg:hidden w-7 h-7 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 dark:bg-slate-900 dark:text-slate-400 dark:hover:text-white grid place-items-center transition"
          aria-label="Close sidebar"
        >
          <i class="fa-solid fa-xmark text-xs"></i>
        </button>
      </div>

      <!-- Scrollable Navigation (Only this section scrolls if viewport is small) -->
      <nav class="flex-1 p-3.5 space-y-3.5 text-xs font-semibold overflow-y-auto custom-sidebar-scroll">
        <!-- Section: Overview -->
        <div>
          <div class="px-2.5 pb-1 text-[9px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
            Core Operations
          </div>
          <div class="space-y-0.5">
            <Link
              href="/admin/dashboard"
              @click="mobileSidebarOpen = false"
              class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition"
              :class="navLinkClass('/admin/dashboard')"
            >
              <i class="fa-solid fa-chart-pie w-4 text-center text-xs"></i>
              <span>Dashboard</span>
            </Link>

            <Link
              href="/admin/inquiries"
              @click="mobileSidebarOpen = false"
              class="flex items-center justify-between px-3 py-2 rounded-xl transition"
              :class="navLinkClass('/admin/inquiries')"
            >
              <div class="flex items-center gap-2.5">
                <i class="fa-solid fa-inbox w-4 text-center text-xs"></i>
                <span>Inquiries & Quotes</span>
              </div>
              <span v-if="activeInquiriesCount > 0" class="bg-brand/10 text-brand dark:bg-brand-light dark:text-navy-950 text-[10px] font-extrabold px-1.5 py-0.2 rounded-full">
                {{ activeInquiriesCount }}
              </span>
            </Link>

          </div>
        </div>

        <!-- Section: Catalog & Offerings -->
        <div>
          <div class="px-2.5 pb-1 text-[9px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
            Services & Products
          </div>
          <div class="space-y-0.5">
            <Link
              href="/admin/services"
              @click="mobileSidebarOpen = false"
              class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition"
              :class="navLinkClass('/admin/services')"
            >
              <i class="fa-solid fa-layer-group w-4 text-center text-xs"></i>
              <span>Services</span>
            </Link>

            <Link
              href="/admin/products"
              @click="mobileSidebarOpen = false"
              class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition"
              :class="navLinkClass('/admin/products')"
            >
              <i class="fa-solid fa-box-open w-4 text-center text-xs"></i>
              <span>Products</span>
            </Link>

            <Link
              href="/admin/portfolio"
              @click="mobileSidebarOpen = false"
              class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition"
              :class="navLinkClass('/admin/portfolio')"
            >
              <i class="fa-solid fa-briefcase w-4 text-center text-xs"></i>
              <span>Portfolio Projects</span>
            </Link>
          </div>
        </div>

        <!-- Section: Marketing & Publishing -->
        <div>
          <div class="px-2.5 pb-1 text-[9px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
            Marketing & Knowledge
          </div>
          <div class="space-y-0.5">
            <Link
              href="/admin/blog-posts"
              @click="mobileSidebarOpen = false"
              class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition"
              :class="navLinkClass('/admin/blog-posts')"
            >
              <i class="fa-solid fa-newspaper w-4 text-center text-xs"></i>
              <span>Blog & Articles</span>
            </Link>

            <Link
              href="/admin/testimonials"
              @click="mobileSidebarOpen = false"
              class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition"
              :class="navLinkClass('/admin/testimonials')"
            >
              <i class="fa-solid fa-comment-dots w-4 text-center text-xs"></i>
              <span>Testimonials</span>
            </Link>

            <Link
              href="/admin/faqs"
              @click="mobileSidebarOpen = false"
              class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition"
              :class="navLinkClass('/admin/faqs')"
            >
              <i class="fa-solid fa-circle-question w-4 text-center text-xs"></i>
              <span>FAQs</span>
            </Link>
          </div>
        </div>

        <!-- Section: Business & Organization -->
        <div>
          <div class="px-2.5 pb-1 text-[9px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
            Business & Team
          </div>
          <div class="space-y-0.5">
            <Link
              href="/admin/pricing-plans"
              @click="mobileSidebarOpen = false"
              class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition"
              :class="navLinkClass('/admin/pricing-plans')"
            >
              <i class="fa-solid fa-tags w-4 text-center text-xs"></i>
              <span>Pricing Plans</span>
            </Link>

            <Link
              href="/admin/team-members"
              @click="mobileSidebarOpen = false"
              class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition"
              :class="navLinkClass('/admin/team-members')"
            >
              <i class="fa-solid fa-users w-4 text-center text-xs"></i>
              <span>Team Members</span>
            </Link>
          </div>
        </div>

        <!-- Live Site Link -->
        <div class="pt-1">
          <a
            href="/"
            target="_blank"
            class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 dark:text-slate-400 dark:hover:text-white dark:hover:bg-slate-800/60 transition"
          >
            <i class="fa-solid fa-arrow-up-right-from-square w-4 text-center text-xs"></i>
            <span>View Live Website</span>
          </a>
        </div>
      </nav>
    </aside>

    <!-- Main Content Wrapper (Fixed in viewport, only content scrolls) -->
    <div class="flex-1 flex flex-col h-full min-w-0 overflow-hidden">
      <!-- Admin Topbar (Pinned at top) -->
      <header class="h-16 bg-white/90 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 px-4 sm:px-8 flex items-center justify-between shrink-0 z-20 transition-colors">
        <div class="flex items-center gap-3">
          <!-- Mobile Hamburger Toggle -->
          <button
            @click="mobileSidebarOpen = true"
            class="lg:hidden w-9 h-9 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-slate-900 dark:bg-slate-950 dark:border-slate-800 dark:text-slate-300 dark:hover:text-white grid place-items-center shadow-sm"
            aria-label="Open sidebar"
          >
            <i class="fa-solid fa-bars text-sm"></i>
          </button>
          <div>
            <h2 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white truncate">{{ title }}</h2>
            <p class="text-[11px] sm:text-xs text-slate-500 dark:text-slate-400 hidden sm:block truncate">{{ subtitle }}</p>
          </div>
        </div>

        <div class="flex items-center gap-2.5 sm:gap-3.5">
          <!-- Notification Icon & Center Dropdown -->
          <div class="relative" ref="notificationMenuRef">
            <button
              @click="notificationsOpen = !notificationsOpen"
              class="w-9 h-9 rounded-xl bg-slate-100 hover:bg-slate-200 border border-slate-200 text-slate-700 dark:bg-slate-800/80 dark:hover:bg-slate-700 dark:border-slate-700/60 dark:text-slate-300 dark:hover:text-white grid place-items-center transition shadow-sm relative"
              :class="{ 'ring-2 ring-brand/40 border-brand': notificationsOpen }"
              aria-label="Notifications"
              title="Notifications"
            >
              <i class="fa-solid fa-bell text-xs"></i>
              <!-- Notification Badge -->
              <span
                v-if="activeInquiriesCount > 0"
                class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-brand text-[9px] font-extrabold text-white shadow-sm ring-2 ring-white dark:ring-slate-900"
              >
                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-brand opacity-75"></span>
                <span class="relative">{{ activeInquiriesCount > 9 ? '9+' : activeInquiriesCount }}</span>
              </span>
            </button>

            <!-- Notification Dropdown Menu -->
            <div
              v-if="notificationsOpen"
              class="absolute right-0 mt-2 w-80 sm:w-96 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-2xl z-50 overflow-hidden animate-fadeIn"
            >
              <!-- Header -->
              <div class="px-4 py-3 bg-slate-50 dark:bg-slate-950/70 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <h4 class="text-xs font-bold text-slate-900 dark:text-white">Notifications</h4>
                  <span
                    v-if="activeInquiriesCount > 0"
                    class="px-1.5 py-0.5 rounded-full text-[9px] font-extrabold bg-brand/10 text-brand dark:bg-brand-light dark:text-navy-950"
                  >
                    {{ activeInquiriesCount }} new
                  </span>
                </div>
                <Link
                  href="/admin/inquiries"
                  @click="notificationsOpen = false"
                  class="text-[10px] font-bold text-brand hover:underline"
                >
                  View All
                </Link>
              </div>

              <!-- Notification Items -->
              <div class="max-h-80 overflow-y-auto divide-y divide-slate-100 dark:divide-slate-800/80 custom-sidebar-scroll">
                <div
                  v-if="notifications.length === 0"
                  class="p-6 text-center text-slate-400 dark:text-slate-500 text-xs"
                >
                  <i class="fa-solid fa-bell-slash text-2xl block mb-2 text-slate-300 dark:text-slate-600"></i>
                  No new notifications right now.
                </div>

                <Link
                  v-for="item in notifications"
                  :key="item.id"
                  href="/admin/inquiries"
                  @click="notificationsOpen = false"
                  class="block p-3.5 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition group"
                >
                  <div class="flex items-start gap-3">
                    <div
                      class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 text-xs mt-0.5"
                      :class="item.type === 'quote' ? 'bg-purple-500/10 text-purple-600 dark:text-purple-400' : 'bg-blue-500/10 text-blue-600 dark:text-blue-400'"
                    >
                      <i :class="item.type === 'quote' ? 'fa-solid fa-file-invoice-dollar' : 'fa-solid fa-envelope'"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                      <div class="flex items-center justify-between gap-1">
                        <p class="text-xs font-bold text-slate-900 dark:text-white truncate group-hover:text-brand transition">
                          {{ item.name }}
                        </p>
                        <span class="text-[10px] text-slate-400 shrink-0">{{ item.time }}</span>
                      </div>
                      <p class="text-[11px] text-slate-500 dark:text-slate-400 truncate">
                        {{ item.type === 'quote' ? 'Quote Request' : 'Direct Inquiry' }} &bull; {{ item.service }}
                      </p>
                    </div>
                  </div>
                </Link>
              </div>

              <!-- Footer -->
              <div class="p-2.5 bg-slate-50 dark:bg-slate-950/70 border-t border-slate-200 dark:border-slate-800 text-center">
                <Link
                  href="/admin/inquiries"
                  @click="notificationsOpen = false"
                  class="text-[11px] font-semibold text-slate-600 dark:text-slate-400 hover:text-brand dark:hover:text-brand inline-flex items-center gap-1 transition"
                >
                  Go to Inquiries & Quote Manager <i class="fa-solid fa-arrow-right text-[9px]"></i>
                </Link>
              </div>
            </div>
          </div>

          <!-- Light/Dark Theme Switcher -->
          <button
            @click="toggleTheme()"
            class="w-9 h-9 rounded-xl bg-slate-100 hover:bg-slate-200 border border-slate-200 text-slate-700 dark:bg-slate-800/80 dark:hover:bg-slate-700 dark:border-slate-700/60 dark:text-slate-300 dark:hover:text-white grid place-items-center transition shadow-sm"
            :title="isDark ? 'Switch to Light Mode' : 'Switch to Dark Mode'"
            aria-label="Toggle Dark/Light Mode"
          >
            <i v-if="isDark" class="fa-solid fa-sun text-amber-400 text-xs"></i>
            <i v-else class="fa-solid fa-moon text-slate-600 text-xs"></i>
          </button>

          <!-- Topbar Divider -->
          <div class="h-6 w-px bg-slate-200 dark:bg-slate-800"></div>

          <!-- Admin Profile Dropdown Menu -->
          <div class="relative" ref="profileMenuRef">
            <button
              @click="profileOpen = !profileOpen"
              class="flex items-center gap-2.5 p-1 pl-1.5 sm:pr-3 rounded-xl bg-slate-100 hover:bg-slate-200 border border-slate-200 text-slate-700 dark:bg-slate-800/80 dark:hover:bg-slate-700 dark:border-slate-700/60 dark:text-slate-200 transition shadow-sm focus:outline-none"
              aria-label="Admin Profile Menu"
            >
              <div class="w-7 h-7 rounded-lg bg-gradient-to-tr from-brand to-orange-400 text-white font-extrabold text-xs grid place-items-center shadow-sm">
                {{ userInitial }}
              </div>
              <div class="hidden sm:block text-left text-xs leading-tight">
                <p class="font-bold text-slate-900 dark:text-white truncate max-w-[110px]">{{ user?.name || 'Administrator' }}</p>
                <p class="text-[10px] text-brand font-semibold">Super Admin</p>
              </div>
              <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 dark:text-slate-500 hidden sm:block transition-transform duration-200" :class="{ 'rotate-180': profileOpen }"></i>
            </button>

            <!-- Profile Dropdown Menu -->
            <div
              v-if="profileOpen"
              class="absolute right-0 mt-2 w-56 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-2xl z-50 overflow-hidden animate-fadeIn"
            >
              <div class="px-4 py-3 border-b border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-950/70">
                <p class="text-xs font-bold text-slate-900 dark:text-white truncate">{{ user?.name || 'Administrator' }}</p>
                <p class="text-[10px] text-slate-500 dark:text-slate-400 truncate">{{ user?.email }}</p>
              </div>
              <div class="p-1.5 space-y-0.5 text-xs font-semibold">
                <Link
                  href="/admin/profile"
                  @click="profileOpen = false"
                  class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-brand dark:hover:text-brand transition"
                >
                  <i class="fa-solid fa-user-gear w-4 text-center text-xs text-slate-400"></i>
                  <span>Profile & Security</span>
                </Link>
                <a
                  href="/"
                  target="_blank"
                  class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition"
                >
                  <i class="fa-solid fa-arrow-up-right-from-square w-4 text-center text-xs text-slate-400"></i>
                  <span>Live Website</span>
                </a>
                <div class="my-1 border-t border-slate-100 dark:border-slate-800"></div>
                <button
                  @click="logout"
                  class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 transition text-left"
                >
                  <i class="fa-solid fa-right-from-bracket w-4 text-center text-xs"></i>
                  <span>Log Out</span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </header>

      <!-- Scrollable Main Viewport (Only this scrolls when scrolling dashboard) -->
      <div class="flex-1 overflow-y-auto overflow-x-hidden bg-slate-100/70 dark:bg-slate-950 custom-sidebar-scroll transition-colors">
        <!-- Toast Container -->
        <Toaster position="top-right" richColors :theme="isDark ? 'dark' : 'light'" />

        <!-- Main Slot -->
        <main class="p-4 sm:p-6 lg:p-8">
          <slot />
        </main>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, ref, watch, provide } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3';
import { Toaster, toast } from 'vue-sonner';
import { useDark, useToggle, onClickOutside } from '@vueuse/core';

const props = defineProps({
  title: { type: String, default: 'Dashboard' },
  subtitle: { type: String, default: 'SoftPolli Operations Center' },
  newInquiriesCount: { type: Number, default: 0 },
});

const isDark = useDark({
  storageKey: 'softpolli_admin_theme',
  valueDark: 'dark',
  valueLight: '',
  initialValue: 'dark',
});
const toggleTheme = useToggle(isDark);
provide('isDark', isDark);

const page = usePage();
const mobileSidebarOpen = ref(false);
const notificationsOpen = ref(false);
const notificationMenuRef = ref(null);
const profileOpen = ref(false);
const profileMenuRef = ref(null);

onClickOutside(notificationMenuRef, () => {
  notificationsOpen.value = false;
});

onClickOutside(profileMenuRef, () => {
  profileOpen.value = false;
});

const user = computed(() => page.props.auth?.user);
const userInitial = computed(() => user.value?.name ? user.value.name.charAt(0).toUpperCase() : 'A');
const activeInquiriesCount = computed(() => props.newInquiriesCount || page.props.newInquiriesCount || 0);
const notifications = computed(() => page.props.recentNotifications || []);

watch(() => page.props.flash, (newFlash) => {
  if (newFlash?.success) {
    toast.success(newFlash.success);
  }
  if (newFlash?.error) {
    toast.error(newFlash.error);
  }
}, { deep: true, immediate: true });

function isActive(url) {
  return page.url.startsWith(url);
}

function navLinkClass(url) {
  return isActive(url)
    ? 'bg-brand text-white shadow-md shadow-brand/25'
    : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 dark:text-slate-400 dark:hover:text-white dark:hover:bg-slate-800/60';
}

function logout() {
  router.post('/admin/logout');
}
</script>

<style scoped>
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-4px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn {
  animation: fadeIn 0.25s ease-out;
}

/* Custom sleek scrollbar */
.custom-sidebar-scroll {
  scrollbar-width: thin;
  scrollbar-color: rgba(148, 163, 184, 0.3) transparent;
}
.custom-sidebar-scroll::-webkit-scrollbar {
  width: 4px;
}
.custom-sidebar-scroll::-webkit-scrollbar-track {
  background: transparent;
}
.custom-sidebar-scroll::-webkit-scrollbar-thumb {
  background: rgba(148, 163, 184, 0.3);
  border-radius: 9999px;
}
.custom-sidebar-scroll::-webkit-scrollbar-thumb:hover {
  background: rgba(241, 89, 42, 0.6);
}
</style>
