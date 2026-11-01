<template>
  <AdminLayout title="Products & Solutions Management" subtitle="Manage enterprise products and software tools showcased on SoftPolli">
    <Head title="Products | SoftPolli Admin" />

    <!-- Action Toolbar -->
    <div class="bg-white border border-slate-200 shadow-sm dark:bg-slate-900 dark:border-slate-800 rounded-3xl p-6 mb-8 flex flex-wrap items-center justify-between gap-4 transition">
      <div class="flex items-center gap-3 w-full sm:w-auto">
        <div class="relative w-full sm:w-72">
          <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 text-xs"></i>
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search products..."
            class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl pl-9 pr-4 py-2 text-xs text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:border-brand shadow-sm"
          />
        </div>
        <span class="text-xs text-slate-500 dark:text-slate-400 whitespace-nowrap">
          <strong class="text-slate-900 dark:text-white">{{ filteredProducts.length }}</strong> products
        </span>
      </div>

      <button
        @click="openCreateModal"
        class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-brand hover:bg-brand-hover text-white text-xs font-bold transition flex items-center justify-center gap-2 shadow-lg shadow-brand/20"
      >
        <i class="fa-solid fa-plus text-xs"></i>
        <span>Add New Product</span>
      </button>
    </div>

    <!-- Products Table -->
    <div class="bg-white border border-slate-200 shadow-sm dark:bg-slate-900 dark:border-slate-800 rounded-3xl overflow-hidden transition">
      <div class="overflow-x-auto">
        <table class="w-full text-xs text-left text-slate-700 dark:text-slate-300 min-w-[640px] bg-white dark:bg-slate-900">
          <thead class="text-[11px] uppercase tracking-wider bg-slate-50 text-slate-600 border-b border-slate-200 dark:bg-slate-950 dark:text-slate-400 dark:border-slate-800">
            <tr>
              <th class="py-4 px-6">Product</th>
              <th class="py-4 px-6">Description</th>
              <th class="py-4 px-6 text-center">Sort</th>
              <th class="py-4 px-6 text-center">Status</th>
              <th class="py-4 px-6 text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100 dark:divide-slate-800/80 bg-white dark:bg-slate-900">
            <tr v-if="filteredProducts.length === 0">
              <td colspan="6" class="py-12 text-center text-slate-400 dark:text-slate-500 bg-white dark:bg-slate-900">
                No products found. Click "Add New Product" to create one.
              </td>
            </tr>
            <tr v-for="item in filteredProducts" :key="item.id" class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition bg-white dark:bg-slate-900">
              <td class="py-4 px-6">
                <div class="flex items-center gap-3">
                  <div
                    class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 border border-slate-200 dark:border-slate-700/60 shadow-sm"
                    :style="{ backgroundColor: item.bg || '#E8E4FF' }"
                  >
                    <i :class="['fa-solid', item.icon || 'fa-gear', 'text-navy-950 text-sm']"></i>
                  </div>
                  <div>
                    <div class="font-semibold text-slate-900 dark:text-white text-sm">{{ item.title }}</div>
                    <div class="text-slate-400 dark:text-slate-500 text-[10px] font-mono">#{{ item.slug }}</div>
                  </div>
                </div>
              </td>
              <td class="py-4 px-6 max-w-sm">
                <p class="truncate text-slate-600 dark:text-slate-400">{{ stripHtml(item.description) }}</p>
              </td>
              <td class="py-4 px-6 text-center font-mono text-slate-500 dark:text-slate-400">
                {{ item.sort_order }}
              </td>
              <td class="py-4 px-6 text-center">
                <button
                  @click="toggleActive(item)"
                  class="px-3 py-1 rounded-full text-[10px] font-bold transition inline-flex items-center justify-center"
                  :class="item.is_active ? 'bg-emerald-50 text-emerald-600 border border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20 hover:bg-emerald-100 dark:hover:bg-emerald-500/20' : 'bg-slate-100 text-slate-600 border border-slate-200 dark:bg-slate-800 dark:text-slate-400 dark:border-slate-700 hover:bg-slate-200 dark:hover:bg-slate-700'"
                >
                  {{ item.is_active ? 'Active' : 'Hidden' }}
                </button>
              </td>
              <td class="py-4 px-6 text-right">
                <div class="flex items-center justify-end gap-2">
                  <button
                    @click="openEditModal(item)"
                    class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-brand hover:text-white text-slate-600 dark:bg-slate-800 dark:text-slate-300 transition grid place-items-center"
                    title="Edit Product"
                  >
                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                  </button>
                  <button
                    @click="deleteItem(item)"
                    class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-red-50 text-slate-400 hover:text-red-500 dark:bg-slate-800 dark:hover:bg-red-500/20 dark:hover:text-red-400 transition grid place-items-center"
                    title="Delete Product"
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
            {{ isEditing ? 'Edit Product' : 'Add New Product' }}
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
            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Product Title *</label>
            <input
              v-model="form.title"
              type="text"
              required
              placeholder="e.g., Enterprise Inventory & POS Suite"
              class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
            />
            <span v-if="form.errors.title" class="text-rose-400 text-[10px] mt-1">{{ form.errors.title }}</span>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">FontAwesome Icon</label>
              <input
                v-model="form.icon"
                type="text"
                placeholder="fa-cart-shopping, fa-chart-line"
                class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
              />
            </div>
            <div>
              <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Background Color</label>
              <input
                v-model="form.bg"
                type="text"
                placeholder="#E8E4FF or #FEF3C7"
                class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
              />
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Sort Order</label>
              <input
                v-model="form.sort_order"
                type="number"
                placeholder="0"
                class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
              />
            </div>
            <div class="flex items-center gap-2 pt-6">
              <input
                id="is_active"
                v-model="form.is_active"
                type="checkbox"
                class="w-4 h-4 rounded bg-slate-50 dark:bg-slate-950 border-slate-300 dark:border-slate-800 text-brand focus:ring-brand"
              />
              <label for="is_active" class="text-xs text-slate-700 dark:text-slate-300 font-semibold cursor-pointer">
                Active on Home
              </label>
            </div>
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Description *</label>
            <RichTextEditor v-model="form.description" />
            <span v-if="form.errors.description" class="text-rose-400 text-[10px] mt-1">{{ form.errors.description }}</span>
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
              <span>{{ isEditing ? 'Save Changes' : 'Create Product' }}</span>
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
import RichTextEditor from '@/Components/RichTextEditor.vue';

const props = defineProps({
  products: Array,
  filters: Object,
});

const searchQuery = ref(props.filters?.search || '');
const showModal = ref(false);
const isEditing = ref(false);
const editingId = ref(null);

const form = useForm({
  title: '',
  slug: '',
  description: '',
  icon: 'fa-gear',
  bg: '#E8E4FF',
  sort_order: 0,
  is_active: true,
});

const filteredProducts = computed(() => {
  if (!searchQuery.value) return props.products;
  const q = searchQuery.value.toLowerCase();
  return props.products.filter(p =>
    p.title?.toLowerCase().includes(q) ||
    p.description?.toLowerCase().includes(q)
  );
});

function openCreateModal() {
  isEditing.value = false;
  editingId.value = null;
  form.reset();
  form.clearErrors();
  form.icon = 'fa-gear';
  form.bg = '#E8E4FF';
  form.is_active = true;
  form.sort_order = props.products.length;
  showModal.value = true;
}

function openEditModal(item) {
  isEditing.value = true;
  editingId.value = item.id;
  form.clearErrors();
  form.title = item.title;
  form.slug = item.slug;
  form.description = item.description;
  form.icon = item.icon || 'fa-gear';
  form.bg = item.bg || '#E8E4FF';
  form.sort_order = item.sort_order;
  form.is_active = Boolean(item.is_active);
  showModal.value = true;
}

function closeModal() {
  showModal.value = false;
  form.reset();
}

function submitForm() {
  if (isEditing.value) {
    form.put(`/admin/products/${editingId.value}`, {
      onSuccess: () => closeModal(),
    });
  } else {
    form.post('/admin/products', {
      onSuccess: () => closeModal(),
    });
  }
}

function toggleActive(item) {
  router.patch(`/admin/products/${item.id}/toggle`, {}, { preserveScroll: true });
}

function deleteItem(item) {
  if (confirm(`Are you sure you want to delete the product '${item.title}'?`)) {
    router.delete(`/admin/products/${item.id}`, { preserveScroll: true });
  }
}

const stripHtml = (html) => (html ? html.replace(/<[^>]*>?/gm, '').trim() : '');
</script>
