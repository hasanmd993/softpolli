<template>
  <AdminLayout title="Portfolio Projects Management" subtitle="Curate case studies, client deliveries, and showcase projects">
    <Head title="Portfolio Projects | SoftPolli Admin" />

    <!-- Action Toolbar -->
    <div class="bg-white border border-slate-200 shadow-sm dark:bg-slate-900 dark:border-slate-800 rounded-3xl p-6 mb-8 flex flex-wrap items-center justify-between gap-4 transition">
      <div class="flex items-center gap-3 w-full sm:w-auto">
        <div class="relative w-full sm:w-72">
          <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 text-xs"></i>
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search projects..."
            class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl pl-9 pr-4 py-2 text-xs text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:border-brand shadow-sm"
          />
        </div>
        <span class="text-xs text-slate-500 dark:text-slate-400 whitespace-nowrap">
          <strong class="text-slate-900 dark:text-white">{{ filteredProjects.length }}</strong> projects
        </span>
      </div>

      <button
        @click="openCreateModal"
        class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-brand hover:bg-brand-hover text-white text-xs font-bold transition flex items-center justify-center gap-2 shadow-lg shadow-brand/20"
      >
        <i class="fa-solid fa-plus text-xs"></i>
        <span>Add Portfolio Project</span>
      </button>
    </div>

    <!-- Projects Table -->
    <div class="bg-white border border-slate-200 shadow-sm dark:bg-slate-900 dark:border-slate-800 rounded-3xl overflow-hidden transition">
      <div class="overflow-x-auto">
        <table class="w-full text-xs text-left text-slate-700 dark:text-slate-300 min-w-[640px] bg-white dark:bg-slate-900">
          <thead class="text-[11px] uppercase tracking-wider bg-slate-50 text-slate-600 border-b border-slate-200 dark:bg-slate-950 dark:text-slate-400 dark:border-slate-800">
            <tr>
              <th class="py-4 px-6">Project</th>
              <th class="py-4 px-6">Category</th>
              <th class="py-4 px-6">Metrics / Outcomes</th>
              <th class="py-4 px-6 text-center">Featured</th>
              <th class="py-4 px-6 text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100 dark:divide-slate-800/80 bg-white dark:bg-slate-900">
            <tr v-if="filteredProjects.length === 0">
              <td colspan="5" class="py-12 text-center text-slate-400 dark:text-slate-500 bg-white dark:bg-slate-900">
                No projects found. Click "Add Portfolio Project" to create one.
              </td>
            </tr>
            <tr v-for="item in filteredProjects" :key="item.id" class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition bg-white dark:bg-slate-900">
              <td class="py-4 px-6">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 overflow-hidden shrink-0 border border-slate-200 dark:border-slate-700/60 flex items-center justify-center">
                    <img v-if="item.image" :src="item.image" :alt="item.title" class="w-full h-full object-cover" />
                    <i v-else class="fa-solid fa-laptop-code text-brand text-sm"></i>
                  </div>
                  <div>
                    <div class="font-semibold text-slate-900 dark:text-white text-sm">{{ item.title }}</div>
                  </div>
                </div>
              </td>
              <td class="py-4 px-6 whitespace-nowrap">
                <span
                  v-if="item.category"
                  class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:border-slate-700 shadow-xs"
                >
                  {{ item.category }}
                </span>
                <span v-else class="text-slate-400 dark:text-slate-600">&mdash;</span>
              </td>
              <td class="py-4 px-6 max-w-xs">
                <p v-if="item.metrics" class="truncate text-slate-600 dark:text-slate-400">
                  {{ item.metrics.length > 30 ? item.metrics.slice(0, 30) + '...' : item.metrics }}
                </p>
                <span v-else class="text-slate-400 dark:text-slate-600">&mdash;</span>
              </td>
              <td class="py-4 px-6 text-center">
                <button
                  @click="toggleFeatured(item)"
                  class="px-3 py-1 rounded-full text-[10px] font-bold transition inline-flex items-center justify-center"
                  :class="item.is_featured ? 'bg-purple-50 text-purple-600 border border-purple-200 dark:bg-purple-500/10 dark:text-purple-300 dark:border-purple-500/20 hover:bg-purple-100 dark:hover:bg-purple-500/20' : 'bg-slate-100 text-slate-600 border border-slate-200 dark:bg-slate-800 dark:text-slate-400 dark:border-slate-700 hover:bg-slate-200 dark:hover:bg-slate-700'"
                >
                  {{ item.is_featured ? 'Featured' : 'Standard' }}
                </button>
              </td>
              <td class="py-4 px-6 text-right">
                <div class="flex items-center justify-end gap-2">
                  <button
                    @click="openEditModal(item)"
                    class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-brand hover:text-white text-slate-600 dark:bg-slate-800 dark:text-slate-300 transition grid place-items-center"
                    title="Edit Project"
                  >
                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                  </button>
                  <button
                    @click="deleteItem(item)"
                    class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-red-50 text-slate-400 hover:text-red-500 dark:bg-slate-800 dark:hover:bg-red-500/20 dark:hover:text-red-400 transition grid place-items-center"
                    title="Delete Project"
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

    <!-- Create / Edit Modal -->
    <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm overflow-y-auto">
      <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl w-full max-w-xl overflow-hidden shadow-2xl max-h-[90vh] flex flex-col my-auto">
        <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between shrink-0">
          <h3 class="font-extrabold text-base text-slate-900 dark:text-white">
            {{ isEditing ? 'Edit Portfolio Project' : 'Add New Portfolio Project' }}
          </h3>
          <button
            type="button"
            @click="closeModal"
            class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-slate-400 dark:hover:text-white transition grid place-items-center shadow-xs"
            title="Close modal"
          >
            <i class="fa-solid fa-xmark text-sm"></i>
          </button>
        </div>

        <form @submit.prevent="submitForm" class="p-6 space-y-4 overflow-y-auto flex-1">
          <div class="grid grid-cols-3 gap-4">
            <div>
              <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Index Number</label>
              <input
                v-model="form.number"
                type="text"
                placeholder="01, 02..."
                class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
              />
            </div>
            <div class="col-span-2">
              <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Project Title *</label>
              <input
                v-model="form.title"
                type="text"
                required
                placeholder="e.g., Apex Health EHR Portal"
                class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
              />
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Category *</label>
              <input
                v-model="form.category"
                type="text"
                required
                placeholder="HealthTech, FinTech, Logistics"
                class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
              />
            </div>
            <div>
              <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Impact Metrics</label>
              <input
                v-model="form.metrics"
                type="text"
                placeholder="+140% Throughput, 99.99% SLA"
                class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
              />
            </div>
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Tagline *</label>
            <input
              v-model="form.tagline"
              type="text"
              required
              placeholder="e.g., Scalable HIPAA-compliant patient management platform"
              class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
            />
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Cover Image *</label>
            <ImageUploader v-model="form.image" />
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Live URL</label>
            <input
              v-model="form.live_url"
              type="text"
              placeholder="https://your-client-site.com"
              class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
            />
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Description *</label>
            <RichTextEditor v-model="form.description" />
            <span v-if="form.errors.description" class="text-rose-400 text-[10px] mt-1">{{ form.errors.description }}</span>
          </div>

          <div class="flex items-center gap-2 pt-2">
            <input
              id="is_featured"
              v-model="form.is_featured"
              type="checkbox"
              class="w-4 h-4 rounded bg-slate-50 dark:bg-slate-950 border-slate-300 dark:border-slate-800 text-brand focus:ring-brand"
            />
            <label for="is_featured" class="text-xs text-slate-700 dark:text-slate-300 font-semibold cursor-pointer">
              Feature on Homepage Showcase
            </label>
          </div>

          <div class="pt-4 border-t border-slate-200 dark:border-slate-800 flex items-center justify-end gap-3">
            <button
              type="button"
              @click="closeModal"
              class="px-4 py-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 dark:text-slate-400 dark:hover:text-white dark:hover:bg-slate-800 text-xs font-bold transition"
            >
              Cancel
            </button>
            <button
              type="submit"
              :disabled="form.processing"
              class="px-5 py-2.5 rounded-xl bg-brand hover:bg-brand-hover text-white text-xs font-bold transition flex items-center gap-2 shadow-lg shadow-brand/20"
            >
              <i v-if="form.processing" class="fa-solid fa-spinner fa-spin text-xs"></i>
              <span>{{ isEditing ? 'Save Changes' : 'Create Project' }}</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ImageUploader from '@/Components/ImageUploader.vue';
import RichTextEditor from '@/Components/RichTextEditor.vue';

const props = defineProps({
  projects: Array,
  filters: Object,
});

const searchQuery = ref(props.filters?.search || '');
const showModal = ref(false);
const isEditing = ref(false);
const editingId = ref(null);

const form = useForm({
  number: '',
  title: '',
  slug: '',
  category: '',
  tagline: '',
  description: '',
  image: '',
  live_url: '#',
  metrics: '',
  sort_order: 0,
  is_featured: true,
});

const filteredProjects = computed(() => {
  if (!searchQuery.value) return props.projects;
  const q = searchQuery.value.toLowerCase();
  return props.projects.filter(p =>
    p.title?.toLowerCase().includes(q) ||
    p.category?.toLowerCase().includes(q) ||
    p.tagline?.toLowerCase().includes(q) ||
    p.description?.toLowerCase().includes(q)
  );
});

function openCreateModal() {
  isEditing.value = false;
  editingId.value = null;
  form.reset();
  form.clearErrors();
  form.number = String(props.projects.length + 1).padStart(2, '0');
  form.is_featured = true;
  form.sort_order = props.projects.length;
  showModal.value = true;
}

function openEditModal(item) {
  isEditing.value = true;
  editingId.value = item.id;
  form.clearErrors();
  form.number = item.number;
  form.title = item.title;
  form.slug = item.slug;
  form.category = item.category;
  form.tagline = item.tagline;
  form.description = item.description;
  form.image = item.image;
  form.live_url = item.live_url || '#';
  form.metrics = item.metrics || '';
  form.sort_order = item.sort_order;
  form.is_featured = Boolean(item.is_featured);
  showModal.value = true;
}

function closeModal() {
  showModal.value = false;
  form.reset();
}

function submitForm() {
  if (isEditing.value) {
    form.put(`/admin/portfolio/${editingId.value}`, {
      onSuccess: () => closeModal(),
    });
  } else {
    form.post('/admin/portfolio', {
      onSuccess: () => closeModal(),
    });
  }
}

function toggleFeatured(item) {
  router.patch(`/admin/portfolio/${item.id}/toggle`, {}, { preserveScroll: true });
}

function deleteItem(item) {
  if (confirm(`Are you sure you want to delete the project '${item.title}'?`)) {
    router.delete(`/admin/portfolio/${item.id}`, { preserveScroll: true });
  }
}
</script>
