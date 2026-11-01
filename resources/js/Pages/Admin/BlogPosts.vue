<template>
  <AdminLayout title="Blog & Articles Management" subtitle="Publish thought leadership, tech tutorials, and company insights">
    <Head title="Blog Posts | SoftPolli Admin" />

    <!-- Action Toolbar -->
    <div class="bg-white border border-slate-200 shadow-sm dark:bg-slate-900 dark:border-slate-800 rounded-3xl p-6 mb-8 flex flex-wrap items-center justify-between gap-4 transition">
      <div class="flex items-center gap-3 w-full sm:w-auto">
        <div class="relative w-full sm:w-72">
          <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 text-xs"></i>
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search articles..."
            class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl pl-9 pr-4 py-2 text-xs text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:border-brand shadow-sm"
          />
        </div>
        <span class="text-xs text-slate-500 dark:text-slate-400 whitespace-nowrap">
          <strong class="text-slate-900 dark:text-white">{{ filteredPosts.length }}</strong> articles
        </span>
      </div>

      <button
        @click="openCreateModal"
        class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-brand hover:bg-brand-hover text-white text-xs font-bold transition flex items-center justify-center gap-2 shadow-lg shadow-brand/20"
      >
        <i class="fa-solid fa-plus text-xs"></i>
        <span>Write New Article</span>
      </button>
    </div>

    <!-- Articles Table -->
    <div class="bg-white border border-slate-200 shadow-sm dark:bg-slate-900 dark:border-slate-800 rounded-3xl overflow-hidden transition">
      <div class="overflow-x-auto">
        <table class="w-full text-xs text-left text-slate-700 dark:text-slate-300 min-w-[640px] bg-white dark:bg-slate-900">
          <thead class="text-[11px] uppercase tracking-wider bg-slate-50 text-slate-600 border-b border-slate-200 dark:bg-slate-950 dark:text-slate-400 dark:border-slate-800">
            <tr>
              <th class="py-4 px-6">Article</th>
              <th class="py-4 px-6">Category</th>
              <th class="py-4 px-6">Author & Date</th>
              <th class="py-4 px-6 text-center">Status</th>
              <th class="py-4 px-6 text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100 dark:divide-slate-800/80 bg-white dark:bg-slate-900">
            <tr v-if="filteredPosts.length === 0">
              <td colspan="5" class="py-12 text-center text-slate-400 dark:text-slate-500 bg-white dark:bg-slate-900">
                No articles found. Click "Write New Article" to publish one.
              </td>
            </tr>
            <tr v-for="item in filteredPosts" :key="item.id" class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition bg-white dark:bg-slate-900">
              <td class="py-4 px-6">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 overflow-hidden shrink-0 border border-slate-200 dark:border-slate-700/60 flex items-center justify-center">
                    <img v-if="item.image" :src="item.image" :alt="item.title" class="w-full h-full object-cover" />
                    <i v-else class="fa-solid fa-newspaper text-brand text-sm"></i>
                  </div>
                  <div>
                    <div class="font-semibold text-slate-900 dark:text-white text-sm line-clamp-1">{{ item.title }}</div>
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
              <td class="py-4 px-6">
                <div class="font-semibold text-slate-800 dark:text-slate-200">{{ item.author }}</div>
                <div class="text-slate-400 dark:text-slate-500 text-[10px]">{{ item.date }} &bull; {{ item.read_time }}</div>
              </td>
              <td class="py-4 px-6 text-center">
                <button
                  @click="togglePublished(item)"
                  class="px-3 py-1 rounded-full text-[10px] font-bold transition inline-flex items-center justify-center"
                  :class="item.is_published ? 'bg-emerald-50 text-emerald-600 border border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20 hover:bg-emerald-100 dark:hover:bg-emerald-500/20' : 'bg-amber-50 text-amber-600 border border-amber-200 dark:bg-amber-500/10 dark:text-amber-400 dark:border-amber-500/20 hover:bg-amber-100 dark:hover:bg-amber-500/20'"
                >
                  {{ item.is_published ? 'Published' : 'Draft' }}
                </button>
              </td>
              <td class="py-4 px-6 text-right">
                <div class="flex items-center justify-end gap-2">
                  <button
                    @click="openEditModal(item)"
                    class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-brand hover:text-white text-slate-600 dark:bg-slate-800 dark:text-slate-300 transition grid place-items-center"
                    title="Edit Article"
                  >
                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                  </button>
                  <button
                    @click="deleteItem(item)"
                    class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-red-50 text-slate-400 hover:text-red-500 dark:bg-slate-800 dark:hover:bg-red-500/20 dark:hover:text-red-400 transition grid place-items-center"
                    title="Delete Article"
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
            {{ isEditing ? 'Edit Article' : 'Write New Article' }}
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
          <div>
            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Article Title *</label>
            <input
              v-model="form.title"
              type="text"
              required
              placeholder="e.g., Designing Resilient Cloud Microservices on Laravel"
              class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
            />
            <span v-if="form.errors.title" class="text-rose-400 text-[10px] mt-1">{{ form.errors.title }}</span>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Category *</label>
              <input
                v-model="form.category"
                type="text"
                required
                placeholder="Architecture, DevOps, AI, Engineering"
                class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
              />
            </div>
            <div>
              <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Read Time</label>
              <input
                v-model="form.read_time"
                type="text"
                placeholder="5 min read"
                class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
              />
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Author *</label>
              <input
                v-model="form.author"
                type="text"
                required
                placeholder="Architect Team"
                class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
              />
            </div>
            <div>
              <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Publication Date</label>
              <input
                v-model="form.date"
                type="text"
                placeholder="Oct 20, 2026"
                class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
              />
            </div>
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Featured Cover Image *</label>
            <ImageUploader v-model="form.image" />
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Excerpt / Summary *</label>
            <RichTextEditor v-model="form.excerpt" />
            <span v-if="form.errors.excerpt" class="text-rose-400 text-[10px] mt-1">{{ form.errors.excerpt }}</span>
          </div>

          <div class="flex items-center gap-2 pt-2">
            <input
              id="is_published"
              v-model="form.is_published"
              type="checkbox"
              class="w-4 h-4 rounded bg-slate-50 dark:bg-slate-950 border-slate-300 dark:border-slate-800 text-brand focus:ring-brand"
            />
            <label for="is_published" class="text-xs text-slate-700 dark:text-slate-300 font-semibold cursor-pointer">
              Published and visible on live blog
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
              <span>{{ isEditing ? 'Save Changes' : 'Publish Article' }}</span>
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
  posts: Array,
  filters: Object,
});

const searchQuery = ref(props.filters?.search || '');
const showModal = ref(false);
const isEditing = ref(false);
const editingId = ref(null);

const form = useForm({
  title: '',
  slug: '',
  category: '',
  read_time: '5 min read',
  date: '',
  excerpt: '',
  image: '',
  author: 'SoftPolli Team',
  is_published: true,
});

const filteredPosts = computed(() => {
  if (!searchQuery.value) return props.posts;
  const q = searchQuery.value.toLowerCase();
  return props.posts.filter(p =>
    p.title?.toLowerCase().includes(q) ||
    p.category?.toLowerCase().includes(q) ||
    p.author?.toLowerCase().includes(q) ||
    p.excerpt?.toLowerCase().includes(q)
  );
});

function openCreateModal() {
  isEditing.value = false;
  editingId.value = null;
  form.reset();
  form.clearErrors();
  form.read_time = '5 min read';
  form.date = new Date().toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
  form.author = 'SoftPolli Engineering';
  form.is_published = true;
  showModal.value = true;
}

function openEditModal(item) {
  isEditing.value = true;
  editingId.value = item.id;
  form.clearErrors();
  form.title = item.title;
  form.slug = item.slug;
  form.category = item.category;
  form.read_time = item.read_time || '5 min read';
  form.date = item.date;
  form.excerpt = item.excerpt;
  form.image = item.image;
  form.author = item.author;
  form.is_published = Boolean(item.is_published);
  showModal.value = true;
}

function closeModal() {
  showModal.value = false;
  form.reset();
}

function submitForm() {
  if (isEditing.value) {
    form.put(`/admin/blog-posts/${editingId.value}`, {
      onSuccess: () => closeModal(),
    });
  } else {
    form.post('/admin/blog-posts', {
      onSuccess: () => closeModal(),
    });
  }
}

function togglePublished(item) {
  router.patch(`/admin/blog-posts/${item.id}/toggle`, {}, { preserveScroll: true });
}

function deleteItem(item) {
  if (confirm(`Are you sure you want to delete the article '${item.title}'?`)) {
    router.delete(`/admin/blog-posts/${item.id}`, { preserveScroll: true });
  }
}
</script>
