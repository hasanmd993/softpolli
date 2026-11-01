<template>
  <AdminLayout title="Team Members Management" subtitle="Manage executive profiles, engineering leads, and specialists">
    <Head title="Team Members | SoftPolli Admin" />

    <!-- Action Toolbar -->
    <div class="bg-white border border-slate-200 shadow-sm dark:bg-slate-900 dark:border-slate-800 rounded-3xl p-6 mb-8 flex flex-wrap items-center justify-between gap-4 transition">
      <div class="flex items-center gap-3 w-full sm:w-auto">
        <div class="relative w-full sm:w-72">
          <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 text-xs"></i>
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search team members..."
            class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl pl-9 pr-4 py-2 text-xs text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:border-brand shadow-sm"
          />
        </div>
        <span class="text-xs text-slate-500 dark:text-slate-400 whitespace-nowrap">
          <strong class="text-slate-900 dark:text-white">{{ filteredMembers.length }}</strong> members
        </span>
      </div>

      <button
        @click="openCreateModal"
        class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-brand hover:bg-brand-hover text-white text-xs font-bold transition flex items-center justify-center gap-2 shadow-lg shadow-brand/20"
      >
        <i class="fa-solid fa-user-plus text-xs"></i>
        <span>Add Team Member</span>
      </button>
    </div>

    <!-- Members Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <div
        v-for="item in filteredMembers"
        :key="item.id"
        class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 text-center hover:border-slate-300 dark:hover:border-slate-700 transition flex flex-col justify-between shadow-sm"
      >
        <div>
          <!-- Photo -->
          <div class="w-20 h-20 mx-auto rounded-2xl bg-slate-100 dark:bg-slate-800 overflow-hidden mb-4 border-2 border-slate-200 dark:border-slate-700 shadow-md">
            <img v-if="item.image" :src="item.image" :alt="item.name" class="w-full h-full object-cover" />
            <div v-else class="w-full h-full grid place-items-center text-brand font-black text-xl">
              {{ item.name.charAt(0) }}
            </div>
          </div>

          <h4 class="font-extrabold text-slate-900 dark:text-white text-sm">{{ item.name }}</h4>
          <p class="text-xs text-brand font-semibold mt-0.5">{{ item.role }}</p>

          <!-- Social Links -->
          <div class="flex items-center justify-center gap-3 mt-4 text-slate-400 dark:text-slate-400 text-xs">
            <a v-if="item.social?.linkedin" :href="item.social.linkedin" target="_blank" class="hover:text-brand transition">
              <i class="fa-brands fa-linkedin"></i>
            </a>
            <a v-if="item.social?.github" :href="item.social.github" target="_blank" class="hover:text-brand transition">
              <i class="fa-brands fa-github"></i>
            </a>
            <a v-if="item.social?.twitter" :href="item.social.twitter" target="_blank" class="hover:text-brand transition">
              <i class="fa-brands fa-x-twitter"></i>
            </a>
          </div>
        </div>

        <!-- Actions -->
        <div class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-center gap-2">
          <button
            @click="openEditModal(item)"
            class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-brand hover:text-white text-slate-600 dark:bg-slate-800 dark:text-slate-300 text-xs font-semibold transition flex items-center gap-1.5"
          >
            <i class="fa-solid fa-pen text-[10px]"></i> Edit
          </button>
          <button
            @click="deleteItem(item)"
            class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-red-50 text-slate-400 hover:text-red-500 dark:bg-slate-800 dark:hover:bg-red-500/20 dark:hover:text-red-400 text-xs font-semibold transition flex items-center gap-1.5"
          >
            <i class="fa-solid fa-trash-can text-[10px]"></i> Delete
          </button>
        </div>
      </div>
    </div>

    <!-- Create / Edit Modal -->
    <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm overflow-y-auto">
      <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl w-full max-w-xl overflow-hidden shadow-2xl max-h-[90vh] flex flex-col my-auto">
        <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between shrink-0">
          <h3 class="font-extrabold text-base text-slate-900 dark:text-white">
            {{ isEditing ? 'Edit Team Member' : 'Add Team Member' }}
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
              <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Full Name *</label>
              <input
                v-model="form.name"
                type="text"
                required
                placeholder="Dr. Kazi Mahfuz"
                class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
              />
            </div>
            <div>
              <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Role / Title *</label>
              <input
                v-model="form.role"
                type="text"
                required
                placeholder="Chief Executive & Architect"
                class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
              />
            </div>
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Photo Avatar *</label>
            <ImageUploader v-model="form.image" />
          </div>

          <!-- Social Links -->
          <div class="space-y-2 pt-2">
            <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Social Links (Optional)</p>
            <div class="grid grid-cols-3 gap-2">
              <input
                v-model="form.social.linkedin"
                type="text"
                placeholder="LinkedIn URL"
                class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-3 py-2 text-[11px] text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
              />
              <input
                v-model="form.social.github"
                type="text"
                placeholder="GitHub URL"
                class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-3 py-2 text-[11px] text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
              />
              <input
                v-model="form.social.twitter"
                type="text"
                placeholder="Twitter / X"
                class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-3 py-2 text-[11px] text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
              />
            </div>
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
              <span>{{ isEditing ? 'Save Changes' : 'Add Member' }}</span>
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

const props = defineProps({
  members: Array,
  filters: Object,
});

const searchQuery = ref(props.filters?.search || '');
const showModal = ref(false);
const isEditing = ref(false);
const editingId = ref(null);

const form = useForm({
  name: '',
  role: '',
  image: '',
  social: {
    linkedin: '',
    github: '',
    twitter: '',
  },
  sort_order: 0,
});

const filteredMembers = computed(() => {
  if (!searchQuery.value) return props.members;
  const q = searchQuery.value.toLowerCase();
  return props.members.filter(m =>
    m.name?.toLowerCase().includes(q) ||
    m.role?.toLowerCase().includes(q)
  );
});

function openCreateModal() {
  isEditing.value = false;
  editingId.value = null;
  form.reset();
  form.clearErrors();
  form.image = `/images/team/member-${(props.members.length % 4) + 1}.png`;
  form.social = { linkedin: '#', github: '#', twitter: '#' };
  form.sort_order = props.members.length;
  showModal.value = true;
}

function openEditModal(item) {
  isEditing.value = true;
  editingId.value = item.id;
  form.clearErrors();
  form.name = item.name;
  form.role = item.role;
  form.image = item.image;
  form.social = {
    linkedin: item.social?.linkedin || '',
    github: item.social?.github || '',
    twitter: item.social?.twitter || '',
  };
  form.sort_order = item.sort_order;
  showModal.value = true;
}

function closeModal() {
  showModal.value = false;
  form.reset();
}

function submitForm() {
  if (isEditing.value) {
    form.put(`/admin/team-members/${editingId.value}`, {
      onSuccess: () => closeModal(),
    });
  } else {
    form.post('/admin/team-members', {
      onSuccess: () => closeModal(),
    });
  }
}

function deleteItem(item) {
  if (confirm(`Are you sure you want to delete '${item.name}'?`)) {
    router.delete(`/admin/team-members/${item.id}`, { preserveScroll: true });
  }
}
</script>
