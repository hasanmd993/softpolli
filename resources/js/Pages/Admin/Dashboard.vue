<template>
  <AdminLayout title="Operational Dashboard" subtitle="Overview of live leads, dynamic content, and system activity">
    <Head title="Admin Dashboard | SoftPolli" />

    <!-- ============ TOP KPI METRICS ============ -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <!-- Card 1: Total Leads -->
      <Link href="/admin/inquiries" class="bg-white border border-slate-200 shadow-sm hover:border-brand dark:bg-slate-900 dark:border-slate-800 dark:hover:border-brand rounded-3xl p-6 relative overflow-hidden group transition">
        <div class="flex items-center justify-between mb-4">
          <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total Leads</span>
          <div class="w-10 h-10 rounded-xl bg-brand/10 text-brand flex items-center justify-center text-base group-hover:scale-110 transition">
            <i class="fa-solid fa-inbox"></i>
          </div>
        </div>
        <p class="text-3xl font-extrabold text-slate-900 dark:text-white mb-1">{{ metrics.total_inquiries }}</p>
        <p class="text-xs text-slate-500 dark:text-slate-400">
          <span class="text-emerald-600 dark:text-emerald-400 font-bold">{{ metrics.new_inquiries }} new</span> awaiting review
        </p>
      </Link>

      <!-- Card 2: Services -->
      <Link href="/admin/services" class="bg-white border border-slate-200 shadow-sm hover:border-brand dark:bg-slate-900 dark:border-slate-800 dark:hover:border-brand rounded-3xl p-6 relative overflow-hidden group transition">
        <div class="flex items-center justify-between mb-4">
          <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Active Services</span>
          <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-500 dark:text-blue-400 flex items-center justify-center text-base group-hover:scale-110 transition">
            <i class="fa-solid fa-layer-group"></i>
          </div>
        </div>
        <p class="text-3xl font-extrabold text-slate-900 dark:text-white mb-1">{{ metrics.services }}</p>
        <p class="text-xs text-slate-500 dark:text-slate-400">Live service offerings</p>
      </Link>

      <!-- Card 3: Products -->
      <Link href="/admin/products" class="bg-white border border-slate-200 shadow-sm hover:border-brand dark:bg-slate-900 dark:border-slate-800 dark:hover:border-brand rounded-3xl p-6 relative overflow-hidden group transition">
        <div class="flex items-center justify-between mb-4">
          <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Software Products</span>
          <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-base group-hover:scale-110 transition">
            <i class="fa-solid fa-box-open"></i>
          </div>
        </div>
        <p class="text-3xl font-extrabold text-slate-900 dark:text-white mb-1">{{ metrics.products }}</p>
        <p class="text-xs text-slate-500 dark:text-slate-400">Featured enterprise tools</p>
      </Link>

      <!-- Card 4: Portfolio Projects -->
      <Link href="/admin/portfolio" class="bg-white border border-slate-200 shadow-sm hover:border-brand dark:bg-slate-900 dark:border-slate-800 dark:hover:border-brand rounded-3xl p-6 relative overflow-hidden group transition">
        <div class="flex items-center justify-between mb-4">
          <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Case Studies</span>
          <div class="w-10 h-10 rounded-xl bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center text-base group-hover:scale-110 transition">
            <i class="fa-solid fa-briefcase"></i>
          </div>
        </div>
        <p class="text-3xl font-extrabold text-slate-900 dark:text-white mb-1">{{ metrics.projects }}</p>
        <p class="text-xs text-slate-500 dark:text-slate-400">Portfolio deliveries</p>
      </Link>
    </div>

    <!-- ============ TAILADMIN VISUAL ANALYTICS (APEXCHARTS) ============ -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
      <!-- Inquiries Velocity Spline Area Chart -->
      <div class="lg:col-span-2 bg-white border border-slate-200 shadow-sm dark:bg-slate-900 dark:border-slate-800 rounded-3xl p-6 relative transition">
        <div class="flex items-center justify-between mb-4">
          <div>
            <h3 class="font-bold text-sm text-slate-900 dark:text-white">Inquiry Velocity & Lead Flow</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400">Monthly quote conversions and contact volume</p>
          </div>
          <span class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 px-2.5 py-1 rounded-full">
            <i class="fa-solid fa-arrow-trend-up mr-1"></i> Live Metric
          </span>
        </div>
        <div class="min-h-[280px]">
          <VueApexCharts
            :key="chartThemeKey"
            type="area"
            height="280"
            :options="areaOptions"
            :series="areaSeries"
          />
        </div>
      </div>

      <!-- Service Portfolio Distribution Donut Chart -->
      <div class="bg-white border border-slate-200 shadow-sm dark:bg-slate-900 dark:border-slate-800 rounded-3xl p-6 relative transition">
        <div class="flex items-center justify-between mb-4">
          <div>
            <h3 class="font-bold text-sm text-slate-900 dark:text-white">Category Distribution</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400">Active catalog breakdown</p>
          </div>
          <span class="text-[11px] font-bold text-purple-600 dark:text-purple-400 bg-purple-50 dark:bg-purple-500/10 border border-purple-200 dark:border-purple-500/20 px-2.5 py-1 rounded-full">
            Catalog
          </span>
        </div>
        <div class="min-h-[280px] flex items-center justify-center">
          <VueApexCharts
            :key="chartThemeKey + '-donut'"
            type="donut"
            height="280"
            :options="donutOptions"
            :series="donutSeries"
          />
        </div>
      </div>
    </div>

    <!-- ============ RECENT INQUIRIES SECTION ============ -->
    <div class="bg-white border border-slate-200 shadow-sm dark:bg-slate-900 dark:border-slate-800 rounded-3xl p-6 sm:p-8 transition">
      <div class="flex items-center justify-between mb-6">
        <div>
          <h3 class="font-extrabold text-lg text-slate-900 dark:text-white">Recent Customer Submissions</h3>
          <p class="text-xs text-slate-500 dark:text-slate-400">Latest leads from the dynamic forms</p>
        </div>
        <Link
          href="/admin/inquiries"
          class="text-xs font-bold text-brand hover:underline inline-flex items-center gap-1"
        >
          View All Inquiries <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </Link>
      </div>

      <!-- Inquiries Table -->
      <div class="overflow-x-auto rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-sm">
        <table class="w-full text-xs text-left text-slate-700 dark:text-slate-300 min-w-[640px] bg-white dark:bg-slate-900">
          <thead class="text-[11px] uppercase tracking-wider bg-slate-50 text-slate-600 border-b border-slate-200 dark:bg-slate-950 dark:text-slate-400 dark:border-slate-800">
            <tr>
              <th class="py-3.5 px-4 font-bold">Type</th>
              <th class="py-3.5 px-4 font-bold">Client Name</th>
              <th class="py-3.5 px-4 font-bold">Contact Info</th>
              <th class="py-3.5 px-4 font-bold">Requested Service</th>
              <th class="py-3.5 px-4 font-bold">Status</th>
              <th class="py-3.5 px-4 text-right font-bold">Date</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100 dark:divide-slate-800/80 bg-white dark:bg-slate-900">
            <tr v-if="recentInquiries.length === 0">
              <td colspan="6" class="py-8 text-center text-slate-400 dark:text-slate-500 bg-white dark:bg-slate-900">
                No inquiries submitted yet. Submit a test form on the public site!
              </td>
            </tr>
            <tr v-for="inquiry in recentInquiries" :key="inquiry.id" class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition bg-white dark:bg-slate-900">
              <td class="py-3.5 px-4 font-semibold">
                <span
                  class="px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase"
                  :class="inquiry.type === 'quote' ? 'bg-purple-50 text-purple-600 border border-purple-200 dark:bg-purple-500/20 dark:text-purple-300 dark:border-purple-500/30' : 'bg-blue-50 text-blue-600 border border-blue-200 dark:bg-blue-500/20 dark:text-blue-300 dark:border-blue-500/30'"
                >
                  {{ inquiry.type }}
                </span>
              </td>
              <td class="py-3.5 px-4 font-bold text-slate-900 dark:text-white">
                {{ inquiry.name }}
                <span v-if="inquiry.company" class="block text-[11px] text-slate-500 dark:text-slate-400 font-normal">
                  {{ inquiry.company }}
                </span>
              </td>
              <td class="py-3.5 px-4">
                <a :href="`mailto:${inquiry.email}`" class="text-brand hover:underline block">{{ inquiry.email }}</a>
                <span v-if="inquiry.phone" class="text-slate-500 dark:text-slate-400 text-[11px]">{{ inquiry.phone }}</span>
              </td>
              <td class="py-3.5 px-4 text-slate-700 dark:text-slate-300">
                {{ inquiry.service || 'General' }}
              </td>
              <td class="py-3.5 px-4">
                <span
                  class="px-2.5 py-1 rounded-full text-[10px] font-bold capitalize"
                  :class="{
                    'bg-emerald-50 text-emerald-600 border border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20': inquiry.status === 'new',
                    'bg-amber-50 text-amber-600 border border-amber-200 dark:bg-amber-500/10 dark:text-amber-400 dark:border-amber-500/20': inquiry.status === 'reviewed',
                    'bg-blue-50 text-blue-600 border border-blue-200 dark:bg-blue-500/10 dark:text-blue-400 dark:border-blue-500/20': inquiry.status === 'contacted',
                    'bg-slate-200 text-slate-700 dark:bg-slate-700 dark:text-slate-300': inquiry.status === 'closed',
                  }"
                >
                  {{ inquiry.status }}
                </span>
              </td>
              <td class="py-3.5 px-4 text-right text-slate-400 dark:text-slate-500 text-[11px]">
                {{ formatDate(inquiry.created_at) }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { computed, defineAsyncComponent, inject, ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const VueApexCharts = defineAsyncComponent(() => import('vue3-apexcharts'));

const props = defineProps({
  metrics: Object,
  analytics: {
    type: Object,
    default: () => ({
      inquiryTrends: { months: [], inquiries: [], quotes: [] },
      serviceDistribution: { labels: [], series: [] },
    }),
  },
  recentInquiries: Array,
});

const isDark = inject('isDark', ref(true));
const chartThemeKey = computed(() => (isDark.value ? 'dark' : 'light'));

const areaSeries = computed(() => [
  {
    name: 'Total Leads',
    data: props.analytics?.inquiryTrends?.inquiries || [0, 0, 0, 0, 0, 0],
  },
  {
    name: 'Quote Inquiries',
    data: props.analytics?.inquiryTrends?.quotes || [0, 0, 0, 0, 0, 0],
  },
]);

const areaOptions = computed(() => {
  const dark = isDark.value;
  return {
    chart: {
      type: 'area',
      toolbar: { show: false },
      fontFamily: 'inherit',
      background: 'transparent',
    },
    colors: ['#f1592a', '#8b5cf6'],
    dataLabels: { enabled: false },
    stroke: { curve: 'smooth', width: 2.5 },
    fill: {
      type: 'gradient',
      gradient: {
        shadeIntensity: 1,
        opacityFrom: 0.45,
        opacityTo: 0.05,
        stops: [0, 95, 100],
      },
    },
    xaxis: {
      categories: props.analytics?.inquiryTrends?.months || ['M1', 'M2', 'M3', 'M4', 'M5', 'M6'],
      labels: { style: { colors: dark ? '#94a3b8' : '#64748b', fontSize: '11px' } },
      axisBorder: { show: false },
      axisTicks: { show: false },
    },
    yaxis: {
      labels: { style: { colors: dark ? '#94a3b8' : '#64748b', fontSize: '11px' } },
    },
    grid: {
      borderColor: dark ? '#334155' : '#e2e8f0',
      strokeDashArray: 4,
    },
    theme: { mode: dark ? 'dark' : 'light' },
    tooltip: { theme: dark ? 'dark' : 'light' },
    legend: {
      position: 'top',
      horizontalAlign: 'right',
      labels: { colors: dark ? '#94a3b8' : '#475569' },
    },
  };
});

const donutSeries = computed(() => props.analytics?.serviceDistribution?.series || [3, 2, 1, 1]);

const donutOptions = computed(() => {
  const dark = isDark.value;
  return {
    chart: {
      type: 'donut',
      fontFamily: 'inherit',
      background: 'transparent',
    },
    labels: props.analytics?.serviceDistribution?.labels || ['Web Engineering', 'Enterprise Arch', 'Growth & Funnels', 'Cyber Security'],
    colors: ['#f1592a', '#3b82f6', '#10b981', '#a855f7', '#f59e0b', '#06b6d4'],
    dataLabels: { enabled: false },
    legend: {
      position: 'bottom',
      labels: { colors: dark ? '#94a3b8' : '#475569' },
      fontSize: '11px',
    },
    plotOptions: {
      pie: {
        donut: {
          size: '72%',
          labels: {
            show: true,
            total: {
              show: true,
              label: 'Services',
              color: dark ? '#94a3b8' : '#64748b',
              fontSize: '11px',
            },
            value: {
              color: dark ? '#ffffff' : '#0f172a',
              fontSize: '20px',
              fontWeight: 800,
            },
          },
        },
      },
    },
    stroke: { width: 0 },
    theme: { mode: dark ? 'dark' : 'light' },
    tooltip: { theme: dark ? 'dark' : 'light' },
  };
});

function formatDate(dateString) {
  if (!dateString) return '';
  const d = new Date(dateString);
  return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });
}
</script>
