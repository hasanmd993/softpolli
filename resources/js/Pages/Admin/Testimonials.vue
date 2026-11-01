<template>
  <AdminLayout title="Client Testimonials Management" subtitle="Manage reviews, corporate endorsements, and client ratings">
    <Head title="Testimonials | SoftPolli Admin" />

    <!-- Action Toolbar -->
    <div class="bg-white border border-slate-200 shadow-sm dark:bg-slate-900 dark:border-slate-800 rounded-3xl p-6 mb-8 flex flex-wrap items-center justify-between gap-4 transition">
      <div class="flex items-center gap-3 w-full sm:w-auto">
        <div class="relative w-full sm:w-72">
          <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 text-xs"></i>
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search testimonials..."
            class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl pl-9 pr-4 py-2 text-xs text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:border-brand shadow-sm"
          />
        </div>
        <span class="text-xs text-slate-500 dark:text-slate-400 whitespace-nowrap">
          <strong class="text-slate-900 dark:text-white">{{ filteredTestimonials.length }}</strong> reviews
        </span>
      </div>

      <button
        @click="openCreateModal"
        class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-brand hover:bg-brand-hover text-white text-xs font-bold transition flex items-center justify-center gap-2 shadow-lg shadow-brand/20"
      >
        <i class="fa-solid fa-plus text-xs"></i>
        <span>Add Testimonial</span>
      </button>
    </div>

    <!-- Testimonials Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div
        v-for="item in filteredTestimonials"
        :key="item.id"
        class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 flex flex-col justify-between hover:border-slate-300 dark:hover:border-slate-700 transition shadow-sm"
      >
        <div>
          <!-- Top info -->
          <div class="flex items-center justify-between mb-4">
            <span class="px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase bg-brand/10 text-brand border border-brand/20">
              {{ item.category }}
            </span>
            <div class="flex items-center gap-1 text-amber-400 text-xs">
              <i v-for="i in 5" :key="i" class="fa-solid fa-star"></i>
            </div>
          </div>

          <!-- Quote -->
          <div class="text-xs text-slate-700 dark:text-slate-300 italic mb-6 leading-relaxed prose prose-xs dark:prose-invert max-w-none [&_p]:mb-1" v-html="sanitizeHtml(item.quote)"></div>
        </div>

        <!-- Author info + Actions -->
        <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden shrink-0 border border-slate-200 dark:border-slate-700">
              <img v-if="item.src" :src="item.src" :alt="item.name" class="w-full h-full object-cover" />
              <div v-else class="w-full h-full grid place-items-center font-bold text-white text-xs bg-brand">
                {{ item.name.charAt(0) }}
              </div>
            </div>
            <div>
              <h4 class="font-bold text-slate-900 dark:text-white text-xs">{{ item.name }}</h4>
              <p class="text-[10px] text-slate-500 dark:text-slate-400">{{ item.designation }} &bull; {{ item.company }}</p>
            </div>
          </div>

          <div class="flex items-center gap-2">
            <button
              @click="openEditModal(item)"
              class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-brand hover:text-white text-slate-600 dark:bg-slate-800 dark:text-slate-300 transition grid place-items-center"
              title="Edit Testimonial"
            >
              <i class="fa-solid fa-pen-to-square text-xs"></i>
            </button>
            <button
              @click="deleteItem(item)"
              class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-red-50 text-slate-400 hover:text-red-500 dark:bg-slate-800 dark:hover:bg-red-500/20 dark:hover:text-red-400 transition grid place-items-center"
              title="Delete Testimonial"
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
            {{ isEditing ? 'Edit Testimonial' : 'Add New Testimonial' }}
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
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Client Name *</label>
              <input
                v-model="form.name"
                type="text"
                required
                placeholder="Dr. Aris Thorne"
                class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
              />
            </div>
            <div>
              <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Company / Organization *</label>
              <input
                v-model="form.company"
                type="text"
                required
                placeholder="Apex Health Group"
                class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
              />
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Designation / Role *</label>
              <input
                v-model="form.designation"
                type="text"
                required
                placeholder="VP of Medical Informatics"
                class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
              />
            </div>
            <div>
              <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Industry / Category *</label>
              <input
                v-model="form.category"
                type="text"
                required
                placeholder="HealthTech, FinTech"
                class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
              />
            </div>
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Client Avatar / Photo *</label>
            <ImageUploader v-model="form.src" />
            <span v-if="form.errors.src" class="text-rose-400 text-[10px] mt-1">{{ form.errors.src }}</span>
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Client Quote *</label>
            <RichTextEditor v-model="form.quote" />
            <span v-if="form.errors.quote" class="text-rose-400 text-[10px] mt-1">{{ form.errors.quote }}</span>
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
              <span>{{ isEditing ? 'Save Changes' : 'Create Testimonial' }}</span>
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
import { sanitizeHtml } from '@/Utils/sanitize';

const props = defineProps({
  testimonials: Array,
  filters: Object,
});

const searchQuery = ref(props.filters?.search || '');
const showModal = ref(false);
const isEditing = ref(false);
const editingId = ref(null);

const form = useForm({
  name: '',
  designation: '',
  company: '',
  category: 'Enterprise Tech',
  quote: '',
  src: '/images/testimonials/avatar-1.png',
  sort_order: 0,
});

const filteredTestimonials = computed(() => {
  if (!searchQuery.value) return props.testimonials;
  const q = searchQuery.value.toLowerCase();
  return props.testimonials.filter(t =>
    t.name?.toLowerCase().includes(q) ||
    t.company?.toLowerCase().includes(q) ||
    t.category?.toLowerCase().includes(q) ||
    t.quote?.toLowerCase().includes(q)
  );
});

function openCreateModal() {
  isEditing.value = false;
  editingId.value = null;
  form.reset();
  form.clearErrors();
  form.src = `/images/testimonials/avatar-${(props.testimonials.length % 2) + 1}.png`;
  form.sort_order = props.testimonials.length;
  showModal.value = true;
}

function openEditModal(item) {
  isEditing.value = true;
  editingId.value = item.id;
  form.clearErrors();
  form.name = item.name;
  form.designation = item.designation;
  form.company = item.company;
  form.category = item.category;
  form.quote = item.quote;
  form.src = item.src;
  form.sort_order = item.sort_order;
  showModal.value = true;
}

function closeModal() {
  showModal.value = false;
  form.reset();
}

function submitForm() {
  if (isEditing.value) {
    form.put(`/admin/testimonials/${editingId.value}`, {
      onSuccess: () => closeModal(),
    });
  } else {
    form.post('/admin/testimonials', {
      onSuccess: () => closeModal(),
    });
  }
}

function deleteItem(item) {
  if (confirm(`Are you sure you want to delete the testimonial from '${item.name}'?`)) {
    router.delete(`/admin/testimonials/${item.id}`, { preserveScroll: true });
  }
}
</script>
