<template>
  <div class="min-h-screen flex flex-col bg-white text-navy-900 font-sans selection:bg-brand selection:text-white">
    <!-- ============ TOP BAR ============ -->
    <div class="hidden md:block bg-navy-950 text-white/80 text-xs border-b border-white/5">
      <div class="max-w-[92%] mx-auto px-6 flex items-center justify-between h-11">
        <div class="flex items-center gap-6">
          <span class="flex items-center gap-2">
            <i class="fa-solid fa-location-dot text-brand"></i>
            2B/4 Ring Road, Shyamoli, Dhaka
          </span>
          <span class="flex items-center gap-2">
            <i class="fa-regular fa-clock text-brand"></i>
            Sat to Thursday: 8:00 am - 7:00 pm
          </span>
        </div>
        <div class="flex items-center gap-6">
          <Link href="/pricing" class="flex items-center gap-2 hover:text-white transition">
            <i class="fa-solid fa-tag text-brand"></i> Pricing
          </Link>
          <Link href="/contact" class="flex items-center gap-2 hover:text-white transition">
            <i class="fa-solid fa-headset text-brand"></i> Support
          </Link>
          <span class="flex items-center gap-2 text-slate-400">
            <i class="fa-solid fa-globe text-brand"></i> EN
          </span>
        </div>
      </div>
    </div>

    <!-- ============ HEADER / STICKY NAV ============ -->
    <header class="sticky top-0 z-50 bg-[#EEF0F4]/90 backdrop-blur-md border-b border-slate-200/80 transition-all duration-300">
      <div class="max-w-[95%] mx-auto px-6 flex items-center justify-between h-20">
        <!-- Logo -->
        <Link href="/" class="flex items-center gap-2 group">
          <img src="/images/SoftPolli-logo-offset.png" alt="SoftPolli Logo" class="w-[140px] xl:w-[175px] hidden md:block transition group-hover:opacity-90">
          <img src="/images/SP-logo.png" alt="SoftPolli Logo" class="w-[50px] rounded-full block md:hidden shadow">
        </Link>

        <!-- Desktop Nav -->
        <nav class="hidden lg:flex items-center gap-7 xl:gap-8 text-sm font-semibold">
          <Link href="/" class="transition py-1" :class="isActive('/') ? 'text-brand border-b-2 border-brand' : 'hover:text-brand text-navy-900'">
            Home
          </Link>
          <Link href="/services" class="transition py-1" :class="isActive('/services') ? 'text-brand border-b-2 border-brand' : 'hover:text-brand text-navy-900'">
            Our Services
          </Link>
          <Link href="/portfolio" class="transition py-1" :class="isActive('/portfolio') ? 'text-brand border-b-2 border-brand' : 'hover:text-brand text-navy-900'">
            Portfolio
          </Link>
          <Link href="/pricing" class="transition py-1" :class="isActive('/pricing') ? 'text-brand border-b-2 border-brand' : 'hover:text-brand text-navy-900'">
            Pricing
          </Link>
          <Link href="/about" class="transition py-1" :class="isActive('/about') ? 'text-brand border-b-2 border-brand' : 'hover:text-brand text-navy-900'">
            About Us
          </Link>
          <Link href="/blog" class="transition py-1" :class="isActive('/blog') ? 'text-brand border-b-2 border-brand' : 'hover:text-brand text-navy-900'">
            Blog
          </Link>
          <Link href="/contact" class="transition py-1" :class="isActive('/contact') ? 'text-brand border-b-2 border-brand' : 'hover:text-brand text-navy-900'">
            Contact
          </Link>
        </nav>

        <!-- CTA & Mobile Trigger -->
        <div class="flex items-center gap-4">
          <Link href="/contact" class="hidden sm:inline-flex items-center gap-2 bg-brand hover:bg-brand-light text-white text-xs xl:text-sm font-bold px-5 xl:px-7 py-3 rounded-full shadow-md shadow-brand/20 transition transform hover:-translate-y-0.5">
            <i class="fa-solid fa-paper-plane text-xs"></i>
            Get In Touch
          </Link>
          <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden grid place-items-center w-11 h-11 rounded-xl bg-navy-900 text-white hover:bg-navy-800 transition" aria-label="Toggle menu">
            <i class="fa-solid" :class="mobileMenuOpen ? 'fa-xmark' : 'fa-bars'"></i>
          </button>
        </div>
      </div>

      <!-- Mobile Dropdown -->
      <transition enter-active-class="transition duration-200 ease-out" enter-from-class="transform -translate-y-4 opacity-0" enter-to-class="transform translate-y-0 opacity-100" leave-active-class="transition duration-150 ease-in" leave-from-class="transform translate-y-0 opacity-100" leave-to-class="transform -translate-y-4 opacity-0">
        <nav v-if="mobileMenuOpen" class="lg:hidden border-t border-slate-200 bg-white shadow-xl">
          <div class="px-6 py-5 flex flex-col gap-3 text-sm font-medium">
            <Link href="/" @click="mobileMenuOpen = false" class="py-2 border-b border-slate-100" :class="isActive('/') ? 'text-brand font-bold' : 'text-navy-900'">Home</Link>
            <Link href="/services" @click="mobileMenuOpen = false" class="py-2 border-b border-slate-100" :class="isActive('/services') ? 'text-brand font-bold' : 'text-navy-900'">Our Services</Link>
            <Link href="/portfolio" @click="mobileMenuOpen = false" class="py-2 border-b border-slate-100" :class="isActive('/portfolio') ? 'text-brand font-bold' : 'text-navy-900'">Portfolio</Link>
            <Link href="/pricing" @click="mobileMenuOpen = false" class="py-2 border-b border-slate-100" :class="isActive('/pricing') ? 'text-brand font-bold' : 'text-navy-900'">Pricing Plans</Link>
            <Link href="/about" @click="mobileMenuOpen = false" class="py-2 border-b border-slate-100" :class="isActive('/about') ? 'text-brand font-bold' : 'text-navy-900'">About Us</Link>
            <Link href="/blog" @click="mobileMenuOpen = false" class="py-2 border-b border-slate-100" :class="isActive('/blog') ? 'text-brand font-bold' : 'text-navy-900'">Tech Blog</Link>
            <Link href="/contact" @click="mobileMenuOpen = false" class="py-2 border-b border-slate-100" :class="isActive('/contact') ? 'text-brand font-bold' : 'text-navy-900'">Contact Us</Link>
            <Link href="/contact" @click="mobileMenuOpen = false" class="mt-2 inline-flex justify-center items-center gap-2 bg-brand text-white font-bold px-6 py-3.5 rounded-full shadow-lg">
              Get In Touch <i class="fa-solid fa-arrow-right text-xs"></i>
            </Link>
          </div>
        </nav>
      </transition>
    </header>

    <!-- ============ FLASH NOTIFICATION TOAST ============ -->
    <transition enter-active-class="transform ease-out duration-300 transition" enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2" enter-to-class="translate-y-0 opacity-100 sm:translate-x-0" leave-active-class="transition ease-in duration-200" leave-from-class="opacity-100" leave-to-class="opacity-0">
      <div v-if="flashMessage" class="fixed bottom-6 right-6 z-50 max-w-md w-full bg-navy-950 text-white rounded-2xl p-4 shadow-2xl border border-brand/40 flex items-start gap-4">
        <div class="w-10 h-10 rounded-xl bg-brand/20 text-brand flex items-center justify-center shrink-0 text-lg">
          <i class="fa-solid fa-circle-check"></i>
        </div>
        <div class="flex-1">
          <h4 class="font-bold text-sm text-white">Notice</h4>
          <p class="text-xs text-slate-300 mt-0.5 leading-relaxed">{{ flashMessage }}</p>
        </div>
        <button @click="dismissFlash" class="text-slate-400 hover:text-white transition text-xs p-1">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>
    </transition>

    <!-- ============ MAIN CONTENT SLOT ============ -->
    <main class="flex-1">
      <slot />
    </main>

    <!-- ============ FOOTER ============ -->
    <footer class="bg-navy-950 text-white/70 border-t border-white/5">
      <!-- Call to Action Banner -->
      <div class="bg-navy-900/80 border-b border-slate-800 py-12">
        <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-6">
          <div>
            <span class="text-xs font-bold text-brand uppercase tracking-widest">Ready to Elevate Your Business?</span>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">Let's build scalable software together.</h3>
          </div>
          <Link href="/contact" class="inline-flex items-center gap-3 bg-brand hover:bg-brand-light text-white font-bold text-xs tracking-wider px-8 py-4 rounded-full uppercase transition shadow-lg shadow-brand/25">
            <i class="fa-solid fa-headset text-base"></i> Let's Talk
          </Link>
        </div>
      </div>

      <!-- Main Footer Columns -->
      <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6 py-16 grid gap-10 sm:grid-cols-2 lg:grid-cols-4 border-b border-slate-800/80">
        <!-- Col 1: Brand Info -->
        <div>
          <Link href="/" class="inline-block mb-5">
            <img src="/images/SoftPolli-logo-offset.png" alt="SoftPolli" class="w-40 brightness-0 invert">
          </Link>
          <p class="text-xs text-slate-400 leading-relaxed mb-6">
            We build reliable, scalable and future-ready software solutions that help businesses automate operations, improve efficiency, and grow faster.
          </p>
          <div class="flex items-center gap-3 text-sm text-slate-400">
            <a href="#" class="w-9 h-9 rounded-full bg-slate-800/80 hover:bg-brand hover:text-white transition grid place-items-center"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#" class="w-9 h-9 rounded-full bg-slate-800/80 hover:bg-brand hover:text-white transition grid place-items-center"><i class="fa-brands fa-linkedin-in"></i></a>
            <a href="#" class="w-9 h-9 rounded-full bg-slate-800/80 hover:bg-brand hover:text-white transition grid place-items-center"><i class="fa-brands fa-x-twitter"></i></a>
            <a href="#" class="w-9 h-9 rounded-full bg-slate-800/80 hover:bg-brand hover:text-white transition grid place-items-center"><i class="fa-brands fa-github"></i></a>
          </div>
        </div>

        <!-- Col 2: Services -->
        <div>
          <h4 class="font-bold text-white text-sm mb-5 relative inline-block">
            Our Services
            <span class="absolute -bottom-1.5 left-0 w-8 h-[2px] bg-brand"></span>
          </h4>
          <ul class="space-y-2.5 text-xs text-slate-400">
            <li><Link href="/services" class="hover:text-brand transition flex items-center gap-2"><i class="fa-solid fa-angle-right text-[10px] text-brand"></i> Enterprise Software</Link></li>
            <li><Link href="/services" class="hover:text-brand transition flex items-center gap-2"><i class="fa-solid fa-angle-right text-[10px] text-brand"></i> Web & Cloud Apps</Link></li>
            <li><Link href="/services" class="hover:text-brand transition flex items-center gap-2"><i class="fa-solid fa-angle-right text-[10px] text-brand"></i> Mobile App Engineering</Link></li>
            <li><Link href="/services" class="hover:text-brand transition flex items-center gap-2"><i class="fa-solid fa-angle-right text-[10px] text-brand"></i> POS & Inventory Systems</Link></li>
            <li><Link href="/services" class="hover:text-brand transition flex items-center gap-2"><i class="fa-solid fa-angle-right text-[10px] text-brand"></i> Cyber Security & Hardening</Link></li>
            <li><Link href="/services" class="hover:text-brand transition flex items-center gap-2"><i class="fa-solid fa-angle-right text-[10px] text-brand"></i> Cloud Hosting & DevOps</Link></li>
          </ul>
        </div>

        <!-- Col 3: Quick Links -->
        <div>
          <h4 class="font-bold text-white text-sm mb-5 relative inline-block">
            Quick Navigation
            <span class="absolute -bottom-1.5 left-0 w-8 h-[2px] bg-brand"></span>
          </h4>
          <ul class="space-y-2.5 text-xs text-slate-400">
            <li><Link href="/about" class="hover:text-brand transition flex items-center gap-2"><i class="fa-solid fa-angle-right text-[10px] text-brand"></i> About SoftPolli</Link></li>
            <li><Link href="/portfolio" class="hover:text-brand transition flex items-center gap-2"><i class="fa-solid fa-angle-right text-[10px] text-brand"></i> Client Portfolio</Link></li>
            <li><Link href="/pricing" class="hover:text-brand transition flex items-center gap-2"><i class="fa-solid fa-angle-right text-[10px] text-brand"></i> Transparent Pricing</Link></li>
            <li><Link href="/blog" class="hover:text-brand transition flex items-center gap-2"><i class="fa-solid fa-angle-right text-[10px] text-brand"></i> Technology Blog</Link></li>
            <li><Link href="/contact" class="hover:text-brand transition flex items-center gap-2"><i class="fa-solid fa-angle-right text-[10px] text-brand"></i> Get A Free Estimate</Link></li>
          </ul>
        </div>

        <!-- Col 4: Newsletter -->
        <div>
          <h4 class="font-bold text-white text-sm mb-5 relative inline-block">
            Newsletter
            <span class="absolute -bottom-1.5 left-0 w-8 h-[2px] bg-brand"></span>
          </h4>
          <p class="text-xs text-slate-400 mb-4 leading-relaxed">
            Subscribe to our newsletter for insights on enterprise software trends, scalability, and digital transformation.
          </p>
          <form @submit.prevent="subscribed = true" class="space-y-2.5">
            <input v-model="emailInput" type="email" placeholder="Your work email..." required class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white placeholder-slate-500 text-xs focus:outline-none focus:border-brand">
            <button type="submit" class="w-full py-3 bg-brand hover:bg-brand-light text-white text-xs font-bold rounded-xl transition shadow">
              {{ subscribed ? '✓ Subscribed!' : 'Subscribe Now' }}
            </button>
          </form>
        </div>
      </div>

      <!-- Sub Footer -->
      <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6 py-6 text-xs text-slate-400 flex flex-col sm:flex-row items-center justify-between gap-4 relative">
        <p>&copy; 2026 SoftPolli. All Rights Reserved. Engineered with Laravel 12 & Vue.js.</p>
        <div class="flex items-center gap-6">
          <Link href="/about" class="hover:text-brand transition">Privacy Policy</Link>
          <Link href="/about" class="hover:text-brand transition">Terms of Service</Link>
          <a href="#" @click.prevent="scrollToTop" class="w-9 h-9 rounded-full bg-brand text-white grid place-items-center hover:scale-110 transition shadow-lg" aria-label="Back to top">
            <i class="fa-solid fa-arrow-up text-xs"></i>
          </a>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
const mobileMenuOpen = ref(false);
const emailInput = ref('');
const subscribed = ref(false);
const manualFlashDismiss = ref(false);

const flashMessage = computed(() => {
  if (manualFlashDismiss.value) return null;
  return page.props.flash?.success || page.props.flash?.error || null;
});

watch(() => page.props.flash, () => {
  manualFlashDismiss.value = false;
  if (page.props.flash?.success || page.props.flash?.error) {
    setTimeout(() => {
      manualFlashDismiss.value = true;
    }, 6000);
  }
}, { deep: true });

function dismissFlash() {
  manualFlashDismiss.value = true;
}

function isActive(routePath) {
  if (routePath === '/') {
    return page.url === '/';
  }
  return page.url.startsWith(routePath);
}

function scrollToTop() {
  window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>
