<template>
  <div class="space-y-12">
    <!-- Header Controls: Category Tabs & Quick Search -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 pb-2">
      <!-- Category Tabs -->
      <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none">
        <button
          v-for="cat in categories"
          :key="cat.id"
          @click="selectedCategory = cat.id"
          class="px-4 py-2.5 rounded-full text-xs font-bold transition-all whitespace-nowrap flex items-center gap-2"
          :class="selectedCategory === cat.id
            ? 'bg-navy-950 text-white shadow-md shadow-navy-950/20'
            : 'bg-slate-100 text-slate-600 hover:bg-slate-200/80 hover:text-slate-900'"
        >
          <i :class="['fa-solid', cat.icon, selectedCategory === cat.id ? 'text-brand' : 'text-slate-400']"></i>
          <span>{{ cat.label }}</span>
          <span
            class="text-[10px] px-1.5 py-0.2 rounded-full font-semibold"
            :class="selectedCategory === cat.id ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600'"
          >
            {{ cat.count }}
          </span>
        </button>
      </div>

      <!-- Quick Filter Search Input -->
      <div class="relative w-full lg:w-72">
        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
        <input
          v-model="searchQuery"
          type="text"
          placeholder="Search products or features..."
          class="w-full bg-slate-50 border border-slate-200 rounded-full pl-9 pr-8 py-2 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-brand focus:bg-white transition shadow-sm"
        />
        <button
          v-if="searchQuery"
          @click="searchQuery = ''"
          class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs"
          aria-label="Clear search"
        >
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>
    </div>

    <!-- Product Cards Grid -->
    <div
      v-if="filteredProducts.length > 0"
      class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6"
    >
      <div
        v-for="product in filteredProducts"
        :key="product.id"
        class="group bg-white rounded-3xl border border-slate-200/90 hover:border-brand/50 shadow-sm hover:shadow-2xl transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between relative overflow-hidden p-6 sm:p-7"
      >
        <!-- Top Accent Border from Product Color -->
        <div
          class="absolute top-0 left-0 right-0 h-1 transition-all duration-300 group-hover:h-1.5"
          :style="{ backgroundColor: getProductColor(product) }"
        ></div>

        <!-- Ambient Background Glow on Hover -->
        <div
          class="absolute -top-16 -right-16 w-36 h-36 rounded-full blur-2xl opacity-0 group-hover:opacity-20 transition-opacity duration-500 pointer-events-none"
          :style="{ backgroundColor: getProductColor(product) }"
        ></div>

        <div>
          <!-- Top Row: Icon Squircle & Status Badge -->
          <div class="flex items-center justify-between gap-3 mb-5">
            <div
              class="w-13 h-13 rounded-2xl flex items-center justify-center text-xl transition-all duration-300 group-hover:scale-110 shadow-sm"
              :style="{
                backgroundColor: getProductColor(product) + '20',
                color: getProductTextColor(product),
              }"
            >
              <i :class="['fa-solid', product.icon]"></i>
            </div>

            <span
              class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border shadow-xs"
              :class="getBadgeClass(product.slug)"
            >
              <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
              {{ getProductMeta(product.slug).badge }}
            </span>
          </div>

          <!-- Title & Category Tag -->
          <div class="mb-3">
            <span class="text-[11px] font-bold text-brand uppercase tracking-wider block mb-1">
              {{ getProductMeta(product.slug).tag }}
            </span>
            <h3 class="font-black text-xl text-navy-950 group-hover:text-brand transition-colors">
              {{ product.title }}
            </h3>
          </div>

          <!-- Description -->
          <div
            class="text-xs text-slate-500 leading-relaxed mb-5 prose prose-xs max-w-none prose-slate [&_p]:mb-1 line-clamp-2"
            v-html="sanitizeHtml(product.description)"
          ></div>

          <!-- Key Capabilities Feature Pills -->
          <div class="space-y-2 mb-6 pt-3 border-t border-slate-100">
            <div
              v-for="(feature, fIdx) in getProductMeta(product.slug).features.slice(0, 3)"
              :key="fIdx"
              class="flex items-center gap-2 text-[11px] text-slate-700 font-medium"
            >
              <i class="fa-solid fa-circle-check text-emerald-500 text-[10px] shrink-0"></i>
              <span class="truncate">{{ feature }}</span>
            </div>
          </div>
        </div>

        <!-- Card Footer Actions -->
        <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-2">
          <button
            @click="openModal(product)"
            class="text-[11px] font-bold text-slate-600 hover:text-navy-900 transition flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg hover:bg-slate-100"
          >
            <i class="fa-solid fa-layer-group text-slate-400"></i>
            Specs
          </button>

          <Link
            :href="`/contact?solution=${encodeURIComponent(product.title)}`"
            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-brand/10 hover:bg-brand text-brand hover:text-white text-xs font-bold transition-all shadow-xs group-hover:shadow-md group-hover:shadow-brand/20"
          >
            <span>Request Demo</span>
            <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-0.5 transition-transform"></i>
          </Link>
        </div>
      </div>
    </div>

    <!-- Empty State for Search / Filter -->
    <div
      v-else
      class="text-center py-16 px-6 bg-slate-50 rounded-3xl border border-dashed border-slate-300"
    >
      <div class="w-14 h-14 rounded-2xl bg-slate-200 text-slate-500 grid place-items-center mx-auto mb-4 text-xl">
        <i class="fa-solid fa-boxes-stacked"></i>
      </div>
      <h4 class="text-base font-bold text-navy-900 mb-1">No products match your criteria</h4>
      <p class="text-xs text-slate-500 max-w-sm mx-auto mb-5">
        Try adjusting your search terms or category selection to discover our software suites.
      </p>
      <button
        @click="resetFilters"
        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-brand text-white text-xs font-bold hover:bg-brand-light transition shadow-sm"
      >
        <i class="fa-solid fa-rotate-left"></i> Reset Filter
      </button>
    </div>

    <!-- Custom Architecture Solution Banner -->
    <div class="relative rounded-3xl bg-gradient-to-r from-navy-950 via-navy-900 to-navy-950 text-white p-8 sm:p-10 lg:p-12 overflow-hidden border border-slate-800 shadow-2xl">
      <!-- Ambient Lighting -->
      <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-brand/20 rounded-full blur-3xl pointer-events-none"></div>

      <div class="relative grid lg:grid-cols-12 gap-8 items-center">
        <div class="lg:col-span-8">
          <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand/20 text-brand-light text-[11px] font-bold uppercase tracking-wider mb-4 border border-brand/30">
            <i class="fa-solid fa-network-wired text-brand"></i> Modular Unified Ecosystem
          </span>
          <h3 class="text-2xl sm:text-3xl font-black text-white tracking-tight leading-tight mb-3">
            Need a tailored combination or custom enterprise module?
          </h3>
          <p class="text-xs sm:text-sm text-slate-300 leading-relaxed max-w-2xl">
            All SoftPolli software suites are architected with unified database schemas and secure REST APIs. We can cross-integrate your CRM, POS, and ERP into a single sovereign dashboard for your enterprise.
          </p>

          <!-- Integration Capabilities Strip -->
          <div class="flex flex-wrap items-center gap-4 mt-6 text-xs text-slate-400">
            <div class="flex items-center gap-2">
              <i class="fa-solid fa-check text-brand"></i>
              <span>Single Sign-On (SSO)</span>
            </div>
            <div class="flex items-center gap-2">
              <i class="fa-solid fa-check text-brand"></i>
              <span>Private Cloud / On-Premise Hosting</span>
            </div>
            <div class="flex items-center gap-2">
              <i class="fa-solid fa-check text-brand"></i>
              <span>Custom Bangladesh Payment & SMS Gateways</span>
            </div>
          </div>
        </div>

        <div class="lg:col-span-4 flex flex-col sm:flex-row lg:flex-col gap-3 justify-center lg:items-end">
          <Link
            href="/contact"
            class="w-full sm:w-auto lg:w-full text-center px-6 py-3.5 rounded-xl bg-brand hover:bg-brand-light text-white text-xs font-bold uppercase tracking-wider transition shadow-lg shadow-brand/25 flex items-center justify-center gap-2"
          >
            <i class="fa-solid fa-calendar-check"></i>
            <span>Book 30-Min Tech Call</span>
          </Link>
          <a
            href="https://wa.me/8801700000000?text=Hello%20SoftPolli%2C%20I%20would%20like%20to%20consult%20about%20your%20software%20products."
            target="_blank"
            rel="noopener noreferrer"
            class="w-full sm:w-auto lg:w-full text-center px-6 py-3.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-bold transition border border-white/10 flex items-center justify-center gap-2"
          >
            <i class="fa-brands fa-whatsapp text-emerald-400"></i>
            <span>Chat With Senior Architect</span>
          </a>
        </div>
      </div>
    </div>

    <!-- Quick Specs & Architecture Modal -->
    <div
      v-if="activeModalProduct"
      class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-navy-950/70 backdrop-blur-sm animate-fade-in"
      @click.self="closeModal"
    >
      <div
        class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all duration-300"
      >
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-navy-950 to-navy-900 text-white p-6 sm:p-8 relative">
          <button
            @click="closeModal"
            class="absolute top-6 right-6 w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 text-white transition flex items-center justify-center text-sm"
            aria-label="Close specifications"
          >
            <i class="fa-solid fa-xmark"></i>
          </button>

          <div class="flex items-center gap-4">
            <div
              class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shadow-lg"
              :style="{
                backgroundColor: getProductColor(activeModalProduct) + '30',
                color: '#fff',
              }"
            >
              <i :class="['fa-solid', activeModalProduct.icon]"></i>
            </div>
            <div>
              <span class="text-xs font-bold text-brand uppercase tracking-wider">
                {{ getProductMeta(activeModalProduct.slug).tag }} &bull; Architecture Specs
              </span>
              <h3 class="text-2xl font-black text-white">
                {{ activeModalProduct.title }}
              </h3>
            </div>
          </div>
        </div>

        <!-- Modal Body -->
        <div class="p-6 sm:p-8 space-y-6 max-h-[70vh] overflow-y-auto">
          <!-- Description -->
          <div>
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Platform Overview</h4>
            <div
              class="text-xs sm:text-sm text-slate-700 leading-relaxed prose prose-sm max-w-none"
              v-html="sanitizeHtml(activeModalProduct.description)"
            ></div>
          </div>

          <!-- Feature Matrix -->
          <div>
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Core Capabilities</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
              <div
                v-for="(f, i) in getProductMeta(activeModalProduct.slug).features"
                :key="i"
                class="flex items-start gap-2.5 p-3 rounded-xl bg-slate-50 border border-slate-100"
              >
                <i class="fa-solid fa-check-circle text-emerald-500 text-xs mt-0.5 shrink-0"></i>
                <span class="text-xs font-semibold text-navy-900">{{ f }}</span>
              </div>
            </div>
          </div>

          <!-- Architectural Readiness Strip -->
          <div class="grid grid-cols-3 gap-3 p-4 rounded-2xl bg-navy-50/50 border border-navy-100 text-center">
            <div>
              <span class="text-[10px] uppercase font-bold text-slate-500 block">Performance</span>
              <span class="text-xs font-black text-brand">{{ getProductMeta(activeModalProduct.slug).metrics }}</span>
            </div>
            <div>
              <span class="text-[10px] uppercase font-bold text-slate-500 block">Deployment</span>
              <span class="text-xs font-black text-navy-950">Cloud & On-Prem</span>
            </div>
            <div>
              <span class="text-[10px] uppercase font-bold text-slate-500 block">SLA Support</span>
              <span class="text-xs font-black text-emerald-600">24/7 Dedicated</span>
            </div>
          </div>
        </div>

        <!-- Modal Footer -->
        <div class="p-5 sm:p-6 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
          <span class="text-xs text-slate-500">Ready to deploy within 7–14 business days.</span>
          <div class="flex items-center gap-3 w-full sm:w-auto">
            <button
              @click="closeModal"
              class="flex-1 sm:flex-none px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-100 transition"
            >
              Close
            </button>
            <Link
              :href="`/contact?solution=${encodeURIComponent(activeModalProduct.title)}`"
              class="flex-1 sm:flex-none px-5 py-2.5 rounded-xl bg-brand hover:bg-brand-light text-white text-xs font-bold transition shadow-md shadow-brand/25 flex items-center justify-center gap-2"
            >
              <span>Schedule Live Demo</span>
              <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </Link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { sanitizeHtml } from '@/Utils/sanitize';

const props = defineProps({
  products: {
    type: Array,
    required: true,
    default: () => [],
  },
});

const selectedCategory = ref('all');
const searchQuery = ref('');
const activeModalProduct = ref(null);

// Metadata enrichment for each product slug
const productMetadata = {
  crm: {
    category: 'operations',
    tag: 'Pipeline & Deal Flow',
    badge: 'Cloud & Mobile',
    features: ['Automated Lead Routing & Ingestion', 'Omnichannel Deal Pipeline', 'Client Activity Timelines', 'Executive Revenue Forecasting'],
    metrics: '3x Faster Lead Conversion',
  },
  'edu-crm': {
    category: 'specialized',
    tag: 'EduTech Academy',
    badge: 'Multi-Counselor',
    features: ['Student Admission Lifecycle', 'University Application Tracking', 'Automated Visa Workflow', 'Tuition Payment Logs & Receipting'],
    metrics: '85% Paperwork Automated',
  },
  hrm: {
    category: 'operations',
    tag: 'Workforce Suite',
    badge: 'Biometric Ready',
    features: ['Biometric Device API Sync', 'Automated Payroll & Tax Calculation', 'Leave & Shift Scheduling', 'Employee Self-Service App'],
    metrics: '100% Payroll Accuracy',
  },
  erp: {
    category: 'operations',
    tag: 'Core Enterprise',
    badge: 'Multi-Branch Sync',
    features: ['Inter-Departmental Workflows', 'Centralized SQL Database Schema', 'Role-Based Access Control (RBAC)', 'Automated Compliance Audit Trails'],
    metrics: '99.99% Uptime Guarantee',
  },
  'e-commerce': {
    category: 'retail',
    tag: 'Digital Commerce',
    badge: 'Payment Gateway',
    features: ['Instant Checkout & Cart Engine', 'Courier API (Pathao/Steadfast)', 'Inventory Stock Lock & Sync', 'Mobile-First Responsive PWA'],
    metrics: 'Sub-second Page Speeds',
  },
  'accounting-software': {
    category: 'specialized',
    tag: 'Financial Suite',
    badge: 'NBR VAT Compliant',
    features: ['Double-Entry General Ledger', 'Real-time Balance Sheet & P&L', 'Automated Recurring Invoices', 'Multi-Currency Bank Reconciliation'],
    metrics: 'Zero Discrepancy Audits',
  },
  'pos-inventory-management': {
    category: 'retail',
    tag: 'Smart Retail',
    badge: 'Offline-First',
    features: ['High-Speed Barcode Scanning', 'Multi-Warehouse Transfers', 'Works Offline Without Internet', 'Cashier Shift Reconciliation'],
    metrics: '< 2s Checkout Speed',
  },
  'restaurant-management': {
    category: 'retail',
    tag: 'Hospitality Tech',
    badge: 'Kitchen KOT Sync',
    features: ['Interactive Floor & Table Map', 'Instant Kitchen Display (KOT)', 'Waiter Tablet Order Taking', 'Ingredient Recipe Cost Tracking'],
    metrics: '40% Faster Table Turnaround',
  },
};

const defaultMeta = {
  category: 'operations',
  tag: 'Enterprise Software',
  badge: 'Ready to Deploy',
  features: ['Role-Based Access Control', 'REST API Integration', 'Automated Data Backups', '24/7 Dedicated SLA Support'],
  metrics: 'Enterprise Grade',
};

function getProductMeta(slug) {
  return productMetadata[slug] || defaultMeta;
}

function getProductColor(product) {
  // Return vibrant accent colors based on slug instead of washed-out backgrounds
  const colorMap = {
    crm: '#6366F1', // Indigo
    'edu-crm': '#10B981', // Emerald
    hrm: '#EC4899', // Pink
    erp: '#3B82F6', // Blue
    'e-commerce': '#F97316', // Orange
    'accounting-software': '#0EA5E9', // Sky
    'pos-inventory-management': '#14B8A6', // Teal
    'restaurant-management': '#F43F5E', // Rose
  };
  return colorMap[product.slug] || '#0d9488';
}

function getProductTextColor(product) {
  return getProductColor(product);
}

function getBadgeClass(slug) {
  const meta = getProductMeta(slug);
  if (meta.category === 'retail') {
    return 'bg-amber-50 text-amber-700 border-amber-200';
  } else if (meta.category === 'specialized') {
    return 'bg-emerald-50 text-emerald-700 border-emerald-200';
  }
  return 'bg-brand/10 text-brand border-brand/20';
}

const categories = computed(() => {
  const allCount = props.products.length;
  const opsCount = props.products.filter(p => getProductMeta(p.slug).category === 'operations').length;
  const retailCount = props.products.filter(p => getProductMeta(p.slug).category === 'retail').length;
  const specCount = props.products.filter(p => getProductMeta(p.slug).category === 'specialized').length;

  return [
    { id: 'all', label: 'All Platforms', icon: 'fa-cubes', count: allCount },
    { id: 'operations', label: 'Enterprise & ERP', icon: 'fa-sitemap', count: opsCount },
    { id: 'retail', label: 'Retail & Hospitality', icon: 'fa-cash-register', count: retailCount },
    { id: 'specialized', label: 'Specialized & Finance', icon: 'fa-wallet', count: specCount },
  ];
});

const filteredProducts = computed(() => {
  return props.products.filter(p => {
    const meta = getProductMeta(p.slug);
    const matchesCategory = selectedCategory.value === 'all' || meta.category === selectedCategory.value;

    const query = searchQuery.value.toLowerCase().trim();
    if (!query) return matchesCategory;

    const matchesQuery =
      p.title.toLowerCase().includes(query) ||
      (p.description && p.description.toLowerCase().includes(query)) ||
      meta.tag.toLowerCase().includes(query) ||
      meta.features.some(f => f.toLowerCase().includes(query));

    return matchesCategory && matchesQuery;
  });
});

function resetFilters() {
  selectedCategory.value = 'all';
  searchQuery.value = '';
}

function openModal(product) {
  activeModalProduct.value = product;
}

function closeModal() {
  activeModalProduct.value = null;
}
</script>

