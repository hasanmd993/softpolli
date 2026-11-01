<template>
  <AdminLayout title="FAQs Knowledgebase Management" subtitle="Manage answers, technical explanations, and engagement questions">
    <Head title="FAQs | SoftPolli Admin" />

    <!-- Action Toolbar -->
    <div class="bg-white border border-slate-200 shadow-sm dark:bg-slate-900 dark:border-slate-800 rounded-3xl p-6 mb-8 flex flex-wrap items-center justify-between gap-4 transition">
      <div class="flex items-center gap-3 w-full sm:w-auto">
        <div class="relative w-full sm:w-72">
          <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 text-xs"></i>
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search FAQs..."
            class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl pl-9 pr-4 py-2 text-xs text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:border-brand shadow-sm"
          />
        </div>
        <span class="text-xs text-slate-500 dark:text-slate-400 whitespace-nowrap">
          <strong class="text-slate-900 dark:text-white">{{ filteredFaqs.length }}</strong> questions
        </span>
      </div>

      <button
        @click="openCreateModal"
        class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-brand hover:bg-brand-hover text-white text-xs font-bold transition flex items-center justify-center gap-2 shadow-lg shadow-brand/20"
      >
        <i class="fa-solid fa-plus text-xs"></i>
        <span>Add New FAQ</span>
      </button>
    </div>

    <!-- FAQ Accordion / Cards List -->
    <div class="space-y-4">
      <div v-if="filteredFaqs.length === 0" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-12 text-center text-slate-400 dark:text-slate-500 text-xs shadow-sm">
        No FAQs matching your search query.
      </div>

      <div
        v-for="item in filteredFaqs"
        :key="item.id"
        class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 hover:border-slate-300 dark:hover:border-slate-700 transition shadow-sm"
      >
        <div class="flex items-start justify-between gap-4">
          <div class="flex items-start gap-4">
            <span class="w-7 h-7 rounded-lg bg-brand/10 text-brand text-xs font-bold grid place-items-center shrink-0 mt-0.5">
              Q
            </span>
            <div>
              <h3 class="font-extrabold text-slate-900 dark:text-white text-sm mb-2">{{ item.question }}</h3>
              <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">{{ item.answer }}</p>
            </div>
          </div>

          <div class="flex items-center gap-2 shrink-0">
            <button
              @click="openEditModal(item)"
              class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-brand hover:text-white text-slate-600 dark:bg-slate-800 dark:text-slate-300 transition grid place-items-center"
              title="Edit FAQ"
            >
              <i class="fa-solid fa-pen-to-square text-xs"></i>
            </button>
            <button
              @click="deleteItem(item)"
              class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-red-50 text-slate-400 hover:text-red-500 dark:bg-slate-800 dark:hover:bg-red-500/20 dark:hover:text-red-400 transition grid place-items-center"
              title="Delete FAQ"
            >
              <i class="fa-solid fa-trash-can text-xs"></i>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Create / Edit Modal -->
    <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm overflow-y-auto">
      <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl w-full max-w-xl overflow-hidden shadow-2xl max-h-[90vh] flex flex-col my-auto">
        <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between shrink-0">
          <h3 class="font-extrabold text-base text-slate-900 dark:text-white">
            {{ isEditing ? 'Edit FAQ' : 'Add New FAQ' }}
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
            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Question *</label>
            <input
              v-model="form.question"
              type="text"
              required
              placeholder="e.g., How does SoftPolli handle enterprise data security & IP ownership?"
              class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
            />
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Answer *</label>
            <textarea
              v-model="form.answer"
              required
              rows="4"
              placeholder="Comprehensive, clear explanation addressing the inquiry..."
              class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
            ></textarea>
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Sort Order</label>
            <input
              v-model="form.sort_order"
              type="number"
              placeholder="0"
              class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
            />
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
              <span>{{ isEditing ? 'Save Changes' : 'Create FAQ' }}</span>
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

const props = defineProps({
  faqs: Array,
  filters: Object,
});

const searchQuery = ref(props.filters?.search || '');
const showModal = ref(false);
const isEditing = ref(false);
const editingId = ref(null);

const form = useForm({
  question: '',
  answer: '',
  sort_order: 0,
});

const filteredFaqs = computed(() => {
  if (!searchQuery.value) return props.faqs;
  const q = searchQuery.value.toLowerCase();
  return props.faqs.filter(f =>
    f.question?.toLowerCase().includes(q) ||
    f.answer?.toLowerCase().includes(q)
  );
});

function openCreateModal() {
  isEditing.value = false;
  editingId.value = null;
  form.reset();
  form.clearErrors();
  form.sort_order = props.faqs.length;
  showModal.value = true;
}

function openEditModal(item) {
  isEditing.value = true;
  editingId.value = item.id;
  form.clearErrors();
  form.question = item.question;
  form.answer = item.answer;
  form.sort_order = item.sort_order;
  showModal.value = true;
}

function closeModal() {
  showModal.value = false;
  form.reset();
}

function submitForm() {
  if (isEditing.value) {
    form.put(`/admin/faqs/${editingId.value}`, {
      onSuccess: () => closeModal(),
    });
  } else {
    form.post('/admin/faqs', {
      onSuccess: () => closeModal(),
    });
  }
}

function deleteItem(item) {
  if (confirm('Are you sure you want to delete this FAQ?')) {
    router.delete(`/admin/faqs/${item.id}`, { preserveScroll: true });
  }
}
</script>
