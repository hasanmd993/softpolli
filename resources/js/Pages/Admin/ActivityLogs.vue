<template>
  <AdminLayout title="Audit Activity Logs" subtitle="Chronological timeline of system events, CMS modifications, and lead updates">
    <Head title="Audit Activity Logs | SoftPolli" />

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
      <div class="relative w-full sm:w-80">
        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 text-xs"></i>
        <input
          v-model="searchQuery"
          type="text"
          placeholder="Filter by subject or causer..."
          class="w-full bg-white border border-slate-200 text-slate-900 placeholder-slate-400 dark:bg-slate-900 dark:border-slate-800 dark:text-white dark:placeholder-slate-500 rounded-xl pl-9 pr-4 py-2 text-xs focus:outline-none focus:border-brand shadow-sm"
        />
      </div>

      <div class="flex items-center gap-2">
        <span class="text-xs text-slate-500 dark:text-slate-400 font-semibold">
          Total Recorded: <strong class="text-slate-900 dark:text-white">{{ activities.total || activities.data.length }}</strong>
        </span>
      </div>
    </div>

    <!-- Activity Log Timeline Table -->
    <div class="bg-white border border-slate-200 shadow-sm dark:bg-slate-900 dark:border-slate-800 rounded-3xl p-6 sm:p-8 transition">
      <div class="overflow-x-auto">
        <table class="w-full text-xs text-left text-slate-700 dark:text-slate-300 min-w-[720px]">
          <thead class="text-[11px] uppercase tracking-wider text-slate-600 border-b border-slate-200 bg-slate-100 dark:text-slate-400 dark:border-slate-800 dark:bg-slate-950/40">
            <tr>
              <th class="py-3 px-4">Event</th>
              <th class="py-3 px-4">Subject</th>
              <th class="py-3 px-4">Causer (Admin)</th>
              <th class="py-3 px-4">Description</th>
              <th class="py-3 px-4">Changes</th>
              <th class="py-3 px-4 text-right">Time</th>
            </tr>
          </thead>
          <tbody class="bg-white dark:bg-slate-900 divide-y divide-slate-100 dark:divide-slate-800/80">
            <tr v-if="filteredActivities.length === 0">
              <td colspan="6" class="py-12 text-center text-slate-400 dark:text-slate-500">
                <i class="fa-solid fa-clock-rotate-left text-2xl block mb-2 text-slate-300 dark:text-slate-600"></i>
                No activity logs recorded yet. Changes in CMS modules will appear here automatically.
              </td>
            </tr>
            <tr v-for="item in filteredActivities" :key="item.id" class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition">
              <!-- Event Badge -->
              <td class="py-3.5 px-4 font-semibold">
                <span
                  class="px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase inline-flex items-center gap-1.5"
                  :class="{
                    'bg-emerald-50 text-emerald-600 border border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/30': item.event === 'created',
                    'bg-blue-50 text-blue-600 border border-blue-200 dark:bg-blue-500/10 dark:text-blue-400 dark:border-blue-500/30': item.event === 'updated',
                    'bg-rose-50 text-rose-600 border border-rose-200 dark:bg-rose-500/10 dark:text-rose-400 dark:border-rose-500/30': item.event === 'deleted',
                    'bg-purple-50 text-purple-600 border border-purple-200 dark:bg-purple-500/10 dark:text-purple-400 dark:border-purple-500/30': !['created', 'updated', 'deleted'].includes(item.event),
                  }"
                >
                  <span
                    class="w-1.5 h-1.5 rounded-full"
                    :class="{
                      'bg-emerald-500 dark:bg-emerald-400': item.event === 'created',
                      'bg-blue-500 dark:bg-blue-400': item.event === 'updated',
                      'bg-rose-500 dark:bg-rose-400': item.event === 'deleted',
                      'bg-purple-500 dark:bg-purple-400': !['created', 'updated', 'deleted'].includes(item.event),
                    }"
                  ></span>
                  {{ item.event || 'action' }}
                </span>
              </td>

              <!-- Subject / Model -->
              <td class="py-3.5 px-4 font-bold text-slate-900 dark:text-white">
                <span class="inline-flex items-center gap-1.5 bg-slate-100 border border-slate-200 dark:bg-slate-800/60 dark:border-slate-700/60 px-2 py-0.5 rounded-md text-[11px]">
                  <i class="fa-solid fa-cube text-[10px] text-brand"></i>
                  {{ item.subject_type }}
                </span>
                <span v-if="item.subject_id" class="text-[10px] text-slate-500 block mt-0.5">
                  ID: #{{ item.subject_id }}
                </span>
              </td>

              <!-- Causer -->
              <td class="py-3.5 px-4">
                <span class="font-bold text-slate-900 dark:text-white block">{{ item.causer_name }}</span>
                <span v-if="item.causer_email" class="text-[10px] text-slate-500 dark:text-slate-400">{{ item.causer_email }}</span>
              </td>

              <!-- Description -->
              <td class="py-3.5 px-4 text-slate-700 dark:text-slate-300">
                <span class="capitalize">{{ item.description }}</span>
              </td>

              <!-- Attributes Changed Summary -->
              <td class="py-3.5 px-4 text-[11px] text-slate-500 dark:text-slate-400">
                <span v-if="item.properties?.attributes" class="inline-block max-w-[200px] truncate">
                  Keys: {{ Object.keys(item.properties.attributes).join(', ') }}
                </span>
                <span v-else class="text-slate-400 dark:text-slate-600">—</span>
              </td>

              <!-- Time -->
              <td class="py-3.5 px-4 text-right">
                <span class="text-slate-900 dark:text-white font-semibold block text-[11px]">{{ item.time_ago }}</span>
                <span class="text-[10px] text-slate-500">{{ item.created_at }}</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination Links (if multiple pages exist) -->
      <div v-if="activities.links && activities.links.length > 3" class="mt-6 pt-4 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between">
        <p class="text-xs text-slate-500 dark:text-slate-400">
          Showing <span class="font-bold text-slate-900 dark:text-white">{{ activities.from || 1 }}</span> to
          <span class="font-bold text-slate-900 dark:text-white">{{ activities.to || activities.data.length }}</span> of
          <span class="font-bold text-slate-900 dark:text-white">{{ activities.total }}</span> results
        </p>
        <div class="flex items-center gap-1">
          <Link
            v-for="(link, index) in activities.links"
            :key="index"
            :href="link.url || '#'"
            v-html="link.label"
            class="px-3 py-1.5 rounded-lg text-xs font-semibold transition"
            :class="link.active ? 'bg-brand text-white shadow-md shadow-brand/20' : link.url ? 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 dark:text-slate-400 dark:hover:text-white dark:hover:bg-slate-800' : 'text-slate-400 dark:text-slate-600 cursor-not-allowed'"
          />
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
  activities: {
    type: Object,
    default: () => ({ data: [], links: [] }),
  },
});

const searchQuery = ref('');

const filteredActivities = computed(() => {
  const list = props.activities?.data || [];
  if (!searchQuery.value) return list;
  const q = searchQuery.value.toLowerCase();
  return list.filter(item =>
    item.subject_type?.toLowerCase().includes(q) ||
    item.causer_name?.toLowerCase().includes(q) ||
    item.event?.toLowerCase().includes(q) ||
    item.description?.toLowerCase().includes(q)
  );
});
</script>
