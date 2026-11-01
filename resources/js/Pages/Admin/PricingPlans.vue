<template>
  <AdminLayout title="Pricing & Packages Management" subtitle="Configure subscription tiers, feature checklists, and enterprise contracts">
    <Head title="Pricing Plans | SoftPolli Admin" />

    <!-- Action Toolbar -->
    <div class="bg-white border border-slate-200 shadow-sm dark:bg-slate-900 dark:border-slate-800 rounded-3xl p-6 mb-8 flex flex-wrap items-center justify-between gap-4 transition">
      <div class="text-xs text-slate-500 dark:text-slate-400">
        Configured <strong class="text-slate-900 dark:text-white">{{ plans.length }}</strong> pricing packages on the live site
      </div>

      <button
        @click="openCreateModal"
        class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-brand hover:bg-brand-hover text-white text-xs font-bold transition flex items-center justify-center gap-2 shadow-lg shadow-brand/20"
      >
        <i class="fa-solid fa-plus text-xs"></i>
        <span>Add Pricing Plan</span>
      </button>
    </div>

    <!-- Pricing Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div
        v-for="plan in plans"
        :key="plan.id"
        class="bg-white dark:bg-slate-900 border rounded-3xl p-6 relative flex flex-col justify-between transition group shadow-sm"
        :class="plan.is_popular ? 'border-brand shadow-xl shadow-brand/10' : 'border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700'"
      >
        <div>
          <!-- Header -->
          <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">{{ plan.audience }}</span>
            <span
              v-if="plan.is_popular"
              class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase bg-brand text-white shadow-sm"
            >
              Popular
            </span>
          </div>

          <h3 class="text-xl font-extrabold text-slate-900 dark:text-white mb-2">{{ plan.name }}</h3>

          <!-- Prices -->
          <div class="my-4 p-4 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800/80">
            <div class="flex items-baseline gap-1">
              <span class="text-2xl font-black text-slate-900 dark:text-white">${{ Number(plan.monthly_price).toLocaleString() }}</span>
              <span class="text-xs text-slate-500 dark:text-slate-400">/mo</span>
            </div>
            <div class="text-[11px] text-slate-500 mt-1">
              or ${{ Number(plan.annual_price).toLocaleString() }}/yr (annual billing)
            </div>
          </div>

          <!-- Features List -->
          <div class="space-y-2 mt-4 text-xs text-slate-700 dark:text-slate-300">
            <p class="text-[10px] uppercase font-bold text-slate-500 tracking-wider">Features Included:</p>
            <ul class="space-y-1.5">
              <li v-for="(feat, idx) in plan.features" :key="idx" class="flex items-start gap-2">
                <i class="fa-solid fa-check text-emerald-500 dark:text-emerald-400 text-[10px] mt-1 shrink-0"></i>
                <span>{{ feat }}</span>
              </li>
            </ul>
          </div>
        </div>

        <!-- Footer Actions -->
        <div class="pt-6 mt-6 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
          <button
            @click="togglePopular(plan)"
            class="text-[10px] font-bold px-3 py-1.5 rounded-lg transition"
            :class="plan.is_popular ? 'bg-amber-50 text-amber-600 border border-amber-200 dark:bg-amber-500/10 dark:text-amber-400 dark:border-amber-500/20' : 'bg-slate-100 text-slate-600 hover:text-slate-900 dark:bg-slate-800 dark:text-slate-400 dark:hover:text-white'"
          >
            <i class="fa-solid fa-star text-[9px] mr-1"></i>
            {{ plan.is_popular ? 'Featured Tier' : 'Set as Popular' }}
          </button>

          <div class="flex items-center gap-2">
            <button
              @click="openEditModal(plan)"
              class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-brand hover:text-white text-slate-600 dark:bg-slate-800 dark:text-slate-300 transition grid place-items-center"
              title="Edit Plan"
            >
              <i class="fa-solid fa-pen-to-square text-xs"></i>
            </button>
            <button
              @click="deleteItem(plan)"
              class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-red-50 text-slate-400 hover:text-red-500 dark:bg-slate-800 dark:hover:bg-red-500/20 dark:hover:text-red-400 transition grid place-items-center"
              title="Delete Plan"
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
            {{ isEditing ? 'Edit Pricing Plan' : 'Add New Pricing Plan' }}
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
              <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Plan Name *</label>
              <input
                v-model="form.name"
                type="text"
                required
                placeholder="Starter, Growth, Enterprise"
                class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
              />
            </div>
            <div>
              <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Target Audience *</label>
              <input
                v-model="form.audience"
                type="text"
                required
                placeholder="Startups, Mid-Market, Global"
                class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
              />
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Monthly Price ($) *</label>
              <input
                v-model="form.monthly_price"
                type="number"
                step="0.01"
                required
                placeholder="999.00"
                class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
              />
            </div>
            <div>
              <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Annual Price ($) *</label>
              <input
                v-model="form.annual_price"
                type="number"
                step="0.01"
                required
                placeholder="9990.00"
                class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-brand shadow-sm"
              />
            </div>
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Features (One per line) *</label>
            <textarea
              v-model="rawFeatures"
              required
              rows="4"
              placeholder="Full Architecture Assessment&#10;Dedicated Laravel Architect&#10;CI/CD Pipeline Setup&#10;99.9% Uptime Guarantee"
              class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white font-mono focus:outline-none focus:border-brand shadow-sm"
            ></textarea>
            <span class="text-[10px] text-slate-500">Enter each feature on a separate line</span>
          </div>

          <div class="flex items-center gap-2 pt-2">
            <input
              id="is_popular"
              v-model="form.is_popular"
              type="checkbox"
              class="w-4 h-4 rounded bg-slate-50 dark:bg-slate-950 border-slate-300 dark:border-slate-800 text-brand focus:ring-brand"
            />
            <label for="is_popular" class="text-xs text-slate-700 dark:text-slate-300 font-semibold cursor-pointer">
              Mark as Popular / Most Recommended Plan
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
              <span>{{ isEditing ? 'Save Changes' : 'Create Plan' }}</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
  plans: Array,
});

const showModal = ref(false);
const isEditing = ref(false);
const editingId = ref(null);
const rawFeatures = ref('');

const form = useForm({
  name: '',
  audience: '',
  monthly_price: '',
  annual_price: '',
  features: '',
  is_popular: false,
  sort_order: 0,
});

function openCreateModal() {
  isEditing.value = false;
  editingId.value = null;
  form.reset();
  form.clearErrors();
  rawFeatures.value = '';
  form.sort_order = props.plans.length;
  showModal.value = true;
}

function openEditModal(plan) {
  isEditing.value = true;
  editingId.value = plan.id;
  form.clearErrors();
  form.name = plan.name;
  form.audience = plan.audience;
  form.monthly_price = plan.monthly_price;
  form.annual_price = plan.annual_price;
  rawFeatures.value = Array.isArray(plan.features) ? plan.features.join('\n') : '';
  form.is_popular = Boolean(plan.is_popular);
  form.sort_order = plan.sort_order;
  showModal.value = true;
}

function closeModal() {
  showModal.value = false;
  form.reset();
  rawFeatures.value = '';
}

function submitForm() {
  form.features = rawFeatures.value;
  if (isEditing.value) {
    form.put(`/admin/pricing-plans/${editingId.value}`, {
      onSuccess: () => closeModal(),
    });
  } else {
    form.post('/admin/pricing-plans', {
      onSuccess: () => closeModal(),
    });
  }
}

function togglePopular(plan) {
  router.patch(`/admin/pricing-plans/${plan.id}/toggle`, {}, { preserveScroll: true });
}

function deleteItem(plan) {
  if (confirm(`Are you sure you want to delete the plan '${plan.name}'?`)) {
    router.delete(`/admin/pricing-plans/${plan.id}`, { preserveScroll: true });
  }
}
</script>
