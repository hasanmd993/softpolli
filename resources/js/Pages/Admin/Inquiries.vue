<template>
  <AdminLayout title="Inquiries & Quote Requests" subtitle="Manage incoming client proposals and consultation messages">
    <Head title="Inquiries & Leads | SoftPolli Admin" />

    <!-- Filters & Search Toolbar -->
    <div class="bg-white border border-slate-200 shadow-sm dark:bg-slate-900 dark:border-slate-800 rounded-3xl p-6 mb-8 flex flex-wrap items-center justify-between gap-4 transition">
      <div class="flex flex-wrap items-center gap-3">
        <!-- Type Filter -->
        <div class="flex items-center gap-1 bg-slate-100 dark:bg-slate-950 p-1 rounded-xl border border-slate-200 dark:border-slate-800 text-xs">
          <button
            @click="filterType('all')"
            class="px-4 py-2 rounded-lg font-bold transition"
            :class="(!filters.type || filters.type === 'all') ? 'bg-brand text-white shadow' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'"
          >
            All Leads
          </button>
          <button
            @click="filterType('quote')"
            class="px-4 py-2 rounded-lg font-bold transition"
            :class="filters.type === 'quote' ? 'bg-brand text-white shadow' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'"
          >
            Quotes
          </button>
          <button
            @click="filterType('contact')"
            class="px-4 py-2 rounded-lg font-bold transition"
            :class="filters.type === 'contact' ? 'bg-brand text-white shadow' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'"
          >
            Contact Messages
          </button>
        </div>

        <!-- Status Filter -->
        <select
          v-model="currentStatus"
          @change="filterStatus"
          class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-800 dark:text-slate-300 focus:outline-none focus:border-brand shadow-sm"
        >
          <option value="all">All Statuses</option>
          <option value="new">New</option>
          <option value="reviewed">Reviewed</option>
          <option value="contacted">Contacted</option>
          <option value="closed">Closed</option>
        </select>
      </div>

      <div class="flex items-center gap-3">
        <a
          href="/admin/inquiries/export"
          class="inline-flex items-center gap-2 px-3.5 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-semibold shadow-sm transition"
        >
          <i class="fa-solid fa-file-excel"></i>
          Export to Excel
        </a>
        <div class="text-xs text-slate-500 dark:text-slate-400">
          Showing <strong class="text-slate-900 dark:text-white">{{ inquiries.data?.length || 0 }}</strong> submissions
        </div>
      </div>
    </div>

    <!-- Main Inquiries Table -->
    <div class="bg-white border border-slate-200 shadow-sm dark:bg-slate-900 dark:border-slate-800 rounded-3xl overflow-hidden transition">
      <div class="overflow-x-auto">
        <table class="w-full text-xs text-left text-slate-700 dark:text-slate-300">
          <thead class="text-[11px] uppercase tracking-wider bg-slate-100 text-slate-600 border-b border-slate-200 dark:bg-slate-950 dark:text-slate-400 dark:border-slate-800">
            <tr>
              <th class="py-4 px-6">ID & Type</th>
              <th class="py-4 px-6">Client / Company</th>
              <th class="py-4 px-6">Service / Scope</th>
              <th class="py-4 px-6">Budget & Timeline</th>
              <th class="py-4 px-6">Status</th>
              <th class="py-4 px-6 text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white dark:bg-slate-900 divide-y divide-slate-100 dark:divide-slate-800/80">
            <tr v-if="inquiries.data.length === 0">
              <td colspan="6" class="py-12 text-center text-slate-400 dark:text-slate-500">
                No inquiries matching the selected filters.
              </td>
            </tr>
            <tr v-for="item in inquiries.data" :key="item.id" class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition">
              <td class="py-4 px-6">
                <span class="font-mono text-slate-400 dark:text-slate-500 block text-[10px]">#{{ item.id }}</span>
                <span
                  class="inline-block mt-1 px-2.5 py-0.5 rounded text-[10px] font-extrabold uppercase"
                  :class="item.type === 'quote' ? 'bg-purple-50 text-purple-600 border border-purple-200 dark:bg-purple-500/20 dark:text-purple-300 dark:border-purple-500/30' : 'bg-blue-50 text-blue-600 border border-blue-200 dark:bg-blue-500/20 dark:text-blue-300 dark:border-blue-500/30'"
                >
                  {{ item.type }}
                </span>
              </td>
              <td class="py-4 px-6">
                <div class="font-bold text-slate-900 dark:text-white text-sm">{{ item.name }}</div>
                <div class="text-slate-500 dark:text-slate-400 text-[11px]">{{ item.email }}</div>
                <div v-if="item.phone" class="text-slate-400 dark:text-slate-500 text-[10px]">{{ item.phone }}</div>
                <span v-if="item.company" class="inline-block mt-1 text-[10px] text-brand font-semibold">
                  {{ item.company }}
                </span>
              </td>
              <td class="py-4 px-6">
                <div class="font-semibold text-slate-800 dark:text-slate-200">{{ item.service || 'General' }}</div>
                <div v-if="item.selected_features && item.selected_features.length" class="text-[10px] text-slate-500 dark:text-slate-400 mt-1">
                  {{ item.selected_features.length }} features requested
                </div>
              </td>
              <td class="py-4 px-6">
                <div v-if="item.budget_range" class="text-brand font-bold">{{ item.budget_range }}</div>
                <div v-if="item.timeline" class="text-slate-500 dark:text-slate-400 text-[10px]">{{ item.timeline }}</div>
                <span v-if="!item.budget_range && !item.timeline" class="text-slate-400 dark:text-slate-600">&mdash;</span>
              </td>
              <td class="py-4 px-6">
                <select
                  :value="item.status"
                  @change="updateStatus(item, $event.target.value)"
                  class="bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-lg px-2.5 py-1 text-[11px] font-bold focus:outline-none focus:border-brand capitalize transition"
                  :class="{
                    'text-emerald-600 dark:text-emerald-400': item.status === 'new',
                    'text-amber-600 dark:text-amber-400': item.status === 'reviewed',
                    'text-blue-600 dark:text-blue-400': item.status === 'contacted',
                    'text-slate-600 dark:text-slate-400': item.status === 'closed',
                  }"
                >
                  <option value="new">New</option>
                  <option value="reviewed">Reviewed</option>
                  <option value="contacted">Contacted</option>
                  <option value="closed">Closed</option>
                </select>
              </td>
              <td class="py-4 px-6 text-right">
                <div class="flex items-center justify-end gap-2">
                  <a
                    :href="`/admin/inquiries/${item.id}/pdf`"
                    class="p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-400 hover:text-brand transition"
                    title="Download PDF Sheet"
                  >
                    <i class="fa-solid fa-file-pdf text-xs"></i>
                  </a>
                  <button
                    @click="viewDetails(item)"
                    class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-brand text-slate-700 hover:text-white dark:bg-slate-800 dark:hover:bg-brand dark:text-white text-xs font-semibold transition"
                  >
                    Details
                  </button>
                  <button
                    @click="deleteInquiry(item)"
                    class="p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-500/20 text-slate-400 hover:text-red-500 dark:hover:text-red-400 transition"
                    title="Delete"
                  >
                    <i class="fa-solid fa-trash-can text-xs"></i>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- ============ DETAIL MODAL ============ -->
    <div v-if="selectedItem" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
      <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl max-w-2xl w-full p-8 shadow-2xl relative max-h-[90vh] overflow-y-auto">
        <button @click="selectedItem = null" class="absolute top-6 right-6 text-slate-400 hover:text-slate-700 dark:hover:text-white transition">
          <i class="fa-solid fa-xmark text-lg"></i>
        </button>

        <div class="flex items-center gap-3 mb-6">
          <span
            class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider"
            :class="selectedItem.type === 'quote' ? 'bg-purple-50 text-purple-600 dark:bg-purple-500/20 dark:text-purple-300' : 'bg-blue-50 text-blue-600 dark:bg-blue-500/20 dark:text-blue-300'"
          >
            {{ selectedItem.type }} #{{ selectedItem.id }}
          </span>
          <span class="text-xs text-slate-400 dark:text-slate-500">{{ formatDate(selectedItem.created_at) }}</span>
        </div>

        <h3 class="text-2xl font-extrabold text-slate-900 dark:text-white mb-1">{{ selectedItem.name }}</h3>
        <p class="text-xs text-slate-500 dark:text-slate-400 mb-6">{{ selectedItem.company || 'Private Client' }}</p>

        <!-- Specs Grid -->
        <div class="grid grid-cols-2 gap-4 bg-slate-50 dark:bg-slate-950 p-5 rounded-2xl border border-slate-200 dark:border-slate-800 text-xs mb-6">
          <div>
            <span class="text-slate-400 dark:text-slate-500 block mb-0.5">Email:</span>
            <a :href="`mailto:${selectedItem.email}`" class="text-brand hover:underline font-semibold">{{ selectedItem.email }}</a>
          </div>
          <div>
            <span class="text-slate-400 dark:text-slate-500 block mb-0.5">Phone:</span>
            <span class="text-slate-900 dark:text-white font-medium">{{ selectedItem.phone || 'N/A' }}</span>
          </div>
          <div>
            <span class="text-slate-400 dark:text-slate-500 block mb-0.5">Target Budget:</span>
            <span class="text-slate-900 dark:text-white font-bold">{{ selectedItem.budget_range || 'Not specified' }}</span>
          </div>
          <div>
            <span class="text-slate-400 dark:text-slate-500 block mb-0.5">Timeline:</span>
            <span class="text-slate-900 dark:text-white font-bold">{{ selectedItem.timeline || 'Flexible' }}</span>
          </div>
        </div>

        <!-- Selected Features -->
        <div v-if="selectedItem.selected_features && selectedItem.selected_features.length" class="mb-6">
          <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-3">Requested Capabilities:</h4>
          <div class="flex flex-wrap gap-2">
            <span
              v-for="f in selectedItem.selected_features"
              :key="f"
              class="px-3 py-1.5 rounded-xl bg-brand/10 border border-brand/20 text-brand dark:text-brand-light text-xs font-semibold"
            >
              {{ f }}
            </span>
          </div>
        </div>

        <!-- Message Body -->
        <div class="mb-8">
          <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Message & Specifications:</h4>
          <div class="bg-slate-50 dark:bg-slate-950 p-5 rounded-2xl border border-slate-200 dark:border-slate-800 text-xs text-slate-700 dark:text-slate-300 leading-relaxed whitespace-pre-line">
            {{ selectedItem.message || 'No additional message provided.' }}
          </div>
        </div>

        <div class="flex items-center justify-between pt-6 border-t border-slate-200 dark:border-slate-800">
          <a
            :href="`/admin/inquiries/${selectedItem.id}/pdf`"
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white dark:bg-white dark:text-slate-900 text-xs font-bold transition shadow-sm"
          >
            <i class="fa-solid fa-file-arrow-down"></i>
            Download PDF
          </a>
          <button
            @click="selectedItem = null"
            class="px-6 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-white text-xs font-semibold transition"
          >
            Close
          </button>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
  inquiries: Object,
  filters: Object,
});

const currentStatus = ref(props.filters.status || 'all');
const selectedItem = ref(null);

function filterType(type) {
  router.get('/admin/inquiries', {
    ...props.filters,
    type,
  }, { preserveState: true });
}

function filterStatus() {
  router.get('/admin/inquiries', {
    ...props.filters,
    status: currentStatus.value,
  }, { preserveState: true });
}

function updateStatus(inquiry, status) {
  router.patch(`/admin/inquiries/${inquiry.id}/status`, { status }, { preserveScroll: true });
}

function deleteInquiry(inquiry) {
  if (confirm(`Are you sure you want to delete inquiry #${inquiry.id}?`)) {
    router.delete(`/admin/inquiries/${inquiry.id}`, { preserveScroll: true });
  }
}

function viewDetails(inquiry) {
  selectedItem.value = inquiry;
}

function formatDate(dateString) {
  if (!dateString) return '';
  const d = new Date(dateString);
  return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit' });
}
</script>
