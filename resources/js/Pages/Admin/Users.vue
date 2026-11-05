<template>
  <AdminLayout title="Staff & Role Management" subtitle="Manage administrator accounts, define roles, and audit access permissions">
    <Head title="Staff & Roles | SoftPolli Admin" />

    <!-- Top Toolbar -->
    <div class="bg-white border border-slate-200 shadow-sm dark:bg-slate-900 dark:border-slate-800 rounded-3xl p-6 mb-8 flex flex-wrap items-center justify-between gap-6 transition">
      <div class="flex items-center gap-5">
        <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-brand to-indigo-600 text-white font-extrabold text-xl grid place-items-center shadow-lg shadow-brand/20 shrink-0">
          <i class="fa-solid fa-user-shield"></i>
        </div>
        <div>
          <div class="flex items-center gap-2.5 flex-wrap">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Role-Based Access Control (RBAC)</h2>
            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-500/10 text-emerald-600 border border-emerald-500/20">
              Spatie Active
            </span>
          </div>
          <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
            Authorize team members with granular module permissions and enterprise roles.
          </p>
        </div>
      </div>

      <div class="flex items-center gap-3">
        <button
          type="button"
          @click="openCreateModal"
          class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-brand hover:bg-brand-light text-white text-xs font-bold transition shadow-md shadow-brand/25"
        >
          <i class="fa-solid fa-plus"></i>
          <span>Add New Staff Account</span>
        </button>
      </div>
    </div>

    <!-- Tab Navigation -->
    <div class="flex items-center gap-2 border-b border-slate-200 dark:border-slate-800 mb-8 overflow-x-auto pb-px">
      <button
        @click="activeTab = 'users'"
        class="flex items-center gap-2 px-5 py-3 border-b-2 text-xs font-bold transition whitespace-nowrap"
        :class="activeTab === 'users' ? 'border-brand text-brand' : 'border-transparent text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white'"
      >
        <i class="fa-solid fa-users"></i>
        <span>Staff Accounts</span>
        <span class="px-2 py-0.5 rounded-full text-[10px] bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">
          {{ users.length }}
        </span>
      </button>

      <button
        @click="activeTab = 'roles'"
        class="flex items-center gap-2 px-5 py-3 border-b-2 text-xs font-bold transition whitespace-nowrap"
        :class="activeTab === 'roles' ? 'border-brand text-brand' : 'border-transparent text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white'"
      >
        <i class="fa-solid fa-shield-halved text-indigo-500"></i>
        <span>Roles & Permissions Matrix</span>
        <span class="px-2 py-0.5 rounded-full text-[10px] bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">
          {{ roles.length }}
        </span>
      </button>
    </div>

    <!-- ================= TAB 1: USERS LIST ================= -->
    <div v-if="activeTab === 'users'" class="space-y-6">
      <!-- Search Filter Bar -->
      <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="relative w-full sm:w-80">
          <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
          <input
            v-model="searchQuery"
            type="text"
            aria-label="Search by name, email, or role"
            class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl pl-9 pr-4 py-2.5 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-brand transition shadow-sm"
          />
        </div>
        <a
          href="/admin/users/export"
          class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-semibold shadow-sm transition"
        >
          <i class="fa-solid fa-file-excel"></i>
          Export Staff (Excel)
        </a>
      </div>

      <!-- Users Table Card -->
      <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse text-xs">
            <thead>
              <tr class="border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/40 text-[11px] uppercase tracking-wider text-slate-500 dark:text-slate-400">
                <th class="p-4 pl-6">Staff Member</th>
                <th class="p-4">Assigned Role</th>
                <th class="p-4">Access Level</th>
                <th class="p-4">Created Date</th>
                <th class="p-4 pr-6 text-right">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
              <tr
                v-for="user in filteredUsers"
                :key="user.id"
                class="hover:bg-slate-50/60 dark:hover:bg-slate-800/30 transition"
              >
                <!-- Name & Email -->
                <td class="p-4 pl-6">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-brand/10 text-brand font-black text-xs flex items-center justify-center shrink-0">
                      {{ user.name.slice(0, 2).toUpperCase() }}
                    </div>
                    <div>
                      <div class="font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <span>{{ user.name }}</span>
                        <span v-if="user.id === currentUserId" class="px-1.5 py-0.2 rounded text-[10px] font-bold bg-brand/10 text-brand border border-brand/20">
                          You
                        </span>
                      </div>
                      <div class="text-[11px] text-slate-500 dark:text-slate-400">{{ user.email }}</div>
                    </div>
                  </div>
                </td>

                <!-- Role Badge -->
                <td class="p-4">
                  <div class="flex flex-wrap gap-1">
                    <span
                      v-for="role in user.roles"
                      :key="role"
                      class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-extrabold uppercase tracking-wider border"
                      :class="getRoleBadgeClass(role)"
                    >
                      <i :class="['fa-solid', getRoleIcon(role), 'text-[9px]']"></i>
                      {{ role }}
                    </span>
                    <span
                      v-if="!user.roles || user.roles.length === 0"
                      class="px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400"
                    >
                      No Role Assigned
                    </span>
                  </div>
                </td>

                <!-- Access Status -->
                <td class="p-4">
                  <span
                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold"
                    :class="user.is_admin ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400'"
                  >
                    <span class="w-1.5 h-1.5 rounded-full" :class="user.is_admin ? 'bg-emerald-500' : 'bg-slate-400'"></span>
                    {{ user.is_admin ? 'Admin Access' : 'Standard Access' }}
                  </span>
                </td>

                <!-- Date -->
                <td class="p-4 text-slate-500 dark:text-slate-400 text-[11px]">
                  {{ user.created_at || 'N/A' }}
                </td>

                <!-- Actions -->
                <td class="p-4 pr-6 text-right">
                  <div class="flex items-center justify-end gap-2">
                    <button
                      @click="openEditModal(user)"
                      class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-brand hover:text-white text-slate-600 dark:bg-slate-800 dark:text-slate-300 transition flex items-center justify-center text-xs"
                      title="Edit Account & Role"
                    >
                      <i class="fa-solid fa-pen-to-square"></i>
                    </button>

                    <button
                      v-if="user.id !== currentUserId"
                      @click="confirmDelete(user)"
                      class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-500 hover:text-white text-red-600 dark:bg-red-950/30 dark:text-red-400 transition flex items-center justify-center text-xs"
                      title="Delete User"
                    >
                      <i class="fa-solid fa-trash-can"></i>
                    </button>
                    <span
                      v-else
                      class="w-8 h-8 rounded-lg bg-slate-100 text-slate-400 dark:bg-slate-800 dark:text-slate-600 flex items-center justify-center text-xs cursor-not-allowed"
                      title="You cannot delete yourself"
                    >
                      <i class="fa-solid fa-ban"></i>
                    </span>
                  </div>
                </td>
              </tr>

              <tr v-if="filteredUsers.length === 0">
                <td colspan="5" class="p-8 text-center text-slate-400">
                  <i class="fa-solid fa-user-xmark text-2xl mb-2 block"></i>
                  No staff accounts found matching your search.
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- ================= TAB 2: ROLES & PERMISSIONS MATRIX ================= -->
    <div v-else class="space-y-6">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div
          v-for="role in roles"
          :key="role.id"
          class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col justify-between"
        >
          <div>
            <div class="flex items-center justify-between gap-3 mb-4">
              <span
                class="w-10 h-10 rounded-xl flex items-center justify-center text-base"
                :class="getRoleContainerClass(role.name)"
              >
                <i :class="['fa-solid', getRoleIcon(role.name)]"></i>
              </span>
              <span class="text-xs px-2.5 py-1 rounded-full font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">
                {{ role.users_count }} {{ role.users_count === 1 ? 'user' : 'users' }}
              </span>
            </div>

            <h3 class="font-extrabold text-base text-slate-900 dark:text-white mb-1">
              {{ role.name }}
            </h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-5">
              {{ getRoleDescription(role.name) }}
            </p>

            <div class="space-y-2 pt-4 border-t border-slate-100 dark:border-slate-800">
              <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-2">
                Included Permissions ({{ role.permissions.length }}):
              </span>
              <div
                v-for="perm in role.permissions"
                :key="perm"
                class="flex items-center gap-2 text-[11px] text-slate-700 dark:text-slate-300 font-medium"
              >
                <i class="fa-solid fa-circle-check text-emerald-500 text-[10px] shrink-0"></i>
                <span class="truncate">{{ perm }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ================= CREATE / EDIT USER MODAL ================= -->
    <div
      v-if="modalOpen"
      class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-navy-950/70 backdrop-blur-sm animate-fade-in"
      @click.self="closeModal"
    >
      <div class="relative w-full max-w-lg bg-white dark:bg-slate-900 rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-navy-950 to-navy-900 text-white p-6 relative">
          <button
            @click="closeModal"
            class="absolute top-5 right-5 w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white transition flex items-center justify-center text-xs"
          >
            <i class="fa-solid fa-xmark"></i>
          </button>
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-brand/20 text-brand flex items-center justify-center text-lg">
              <i class="fa-solid" :class="isEditing ? 'fa-user-pen' : 'fa-user-plus'"></i>
            </div>
            <div>
              <h3 class="font-bold text-base text-white">
                {{ isEditing ? 'Edit Staff Account' : 'Create Staff Account' }}
              </h3>
              <p class="text-xs text-slate-300">
                {{ isEditing ? 'Update profile and assigned roles.' : 'Invite a new team member with specific role permissions.' }}
              </p>
            </div>
          </div>
        </div>

        <!-- Modal Form -->
        <form @submit.prevent="submitForm" class="p-6 space-y-4 text-xs">
          <!-- Name -->
          <div>
            <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Full Name *</label>
            <input
              v-model="form.name"
              type="text"
              required
              class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white focus:outline-none focus:border-brand transition"
            />
            <div v-if="form.errors.name" class="text-red-500 text-[11px] mt-1">{{ form.errors.name }}</div>
          </div>

          <!-- Email -->
          <div>
            <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Email Address *</label>
            <input
              v-model="form.email"
              type="email"
              required
              class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white focus:outline-none focus:border-brand transition"
            />
            <div v-if="form.errors.email" class="text-red-500 text-[11px] mt-1">{{ form.errors.email }}</div>
          </div>

          <!-- Password -->
          <div>
            <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">
              {{ isEditing ? 'New Password (Leave blank to keep current)' : 'Password *' }}
            </label>
            <input
              v-model="form.password"
              type="password"
              :required="!isEditing"
              class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white focus:outline-none focus:border-brand transition"
            />
            <div v-if="form.errors.password" class="text-red-500 text-[11px] mt-1">{{ form.errors.password }}</div>
          </div>

          <!-- Role Dropdown -->
          <div>
            <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1">Assigned Role *</label>
            <select
              v-model="form.role"
              required
              class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white focus:outline-none focus:border-brand transition"
            >
              <option v-for="r in roles" :key="r.id" :value="r.name">
                {{ r.name }}
              </option>
            </select>
            <div v-if="form.errors.role" class="text-red-500 text-[11px] mt-1">{{ form.errors.role }}</div>
          </div>

          <!-- Actions -->
          <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3">
            <button
              type="button"
              @click="closeModal"
              class="px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-100 dark:hover:bg-slate-800 transition"
            >
              Cancel
            </button>
            <button
              type="submit"
              :disabled="form.processing"
              class="px-5 py-2 rounded-xl bg-brand hover:bg-brand-light text-white font-bold transition shadow-md shadow-brand/25 disabled:opacity-50"
            >
              <span v-if="form.processing"><i class="fa-solid fa-spinner fa-spin mr-1"></i> Saving...</span>
              <span v-else>{{ isEditing ? 'Update Account' : 'Create Account' }}</span>
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- ================= DELETE CONFIRMATION MODAL ================= -->
    <div
      v-if="userToDelete"
      class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-navy-950/70 backdrop-blur-sm animate-fade-in"
      @click.self="userToDelete = null"
    >
      <div class="relative w-full max-w-sm bg-white dark:bg-slate-900 rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800 p-6 text-center">
        <div class="w-14 h-14 rounded-2xl bg-red-500/10 text-red-500 grid place-items-center mx-auto mb-4 text-2xl">
          <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <h4 class="font-bold text-base text-slate-900 dark:text-white mb-1">Delete Staff Account?</h4>
        <p class="text-xs text-slate-500 dark:text-slate-400 mb-6">
          Are you sure you want to delete <strong class="text-slate-900 dark:text-white">{{ userToDelete.name }}</strong>? This action cannot be undone.
        </p>
        <div class="flex items-center gap-3">
          <button
            @click="userToDelete = null"
            class="flex-1 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition"
          >
            Cancel
          </button>
          <button
            @click="deleteUser"
            class="flex-1 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-xs font-bold text-white transition shadow-md shadow-red-600/25"
          >
            Delete
          </button>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
  users: {
    type: Array,
    required: true,
  },
  roles: {
    type: Array,
    required: true,
  },
  permissions: {
    type: Array,
    required: true,
  },
  currentUserId: {
    type: Number,
    required: true,
  },
});

const activeTab = ref('users');
const searchQuery = ref('');
const modalOpen = ref(false);
const isEditing = ref(false);
const editingUserId = ref(null);
const userToDelete = ref(null);

const form = useForm({
  name: '',
  email: '',
  password: '',
  role: 'Admin',
});

const filteredUsers = computed(() => {
  if (!searchQuery.value.trim()) return props.users;
  const q = searchQuery.value.toLowerCase();
  return props.users.filter(u =>
    u.name.toLowerCase().includes(q) ||
    u.email.toLowerCase().includes(q) ||
    u.roles.some(r => r.toLowerCase().includes(q))
  );
});

function getRoleBadgeClass(role) {
  switch (role) {
    case 'Super Admin':
      return 'bg-purple-500/10 text-purple-600 dark:text-purple-400 border-purple-500/20';
    case 'Admin':
      return 'bg-brand/10 text-brand border-brand/20';
    case 'Editor':
      return 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/20';
    case 'Support Agent':
      return 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border-amber-500/20';
    default:
      return 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400 border-slate-200';
  }
}

function getRoleContainerClass(role) {
  switch (role) {
    case 'Super Admin':
      return 'bg-purple-500/10 text-purple-600 dark:text-purple-400';
    case 'Admin':
      return 'bg-brand/10 text-brand';
    case 'Editor':
      return 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400';
    case 'Support Agent':
      return 'bg-amber-500/10 text-amber-600 dark:text-amber-400';
    default:
      return 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400';
  }
}

function getRoleIcon(role) {
  switch (role) {
    case 'Super Admin':
      return 'fa-crown';
    case 'Admin':
      return 'fa-shield-halved';
    case 'Editor':
      return 'fa-file-pen';
    case 'Support Agent':
      return 'fa-headset';
    default:
      return 'fa-user';
  }
}

function getRoleDescription(role) {
  switch (role) {
    case 'Super Admin':
      return 'Unrestricted sovereign access to all systems, settings, and team roles.';
    case 'Admin':
      return 'Full operational management of all content, catalogs, and inquiries.';
    case 'Editor':
      return 'Manage blog articles, services, products, testimonials, and FAQs.';
    case 'Support Agent':
      return 'Handle and update client inquiries and quote requests.';
    default:
      return 'Custom staff role.';
  }
}

function openCreateModal() {
  isEditing.value = false;
  editingUserId.value = null;
  form.reset();
  form.clearErrors();
  form.role = props.roles[0]?.name || 'Admin';
  modalOpen.value = true;
}

function openEditModal(user) {
  isEditing.value = true;
  editingUserId.value = user.id;
  form.clearErrors();
  form.name = user.name;
  form.email = user.email;
  form.password = '';
  form.role = user.roles[0] || 'Admin';
  modalOpen.value = true;
}

function closeModal() {
  modalOpen.value = false;
  form.reset();
}

function submitForm() {
  if (isEditing.value) {
    form.put(`/admin/users/${editingUserId.value}`, {
      preserveScroll: true,
      onSuccess: () => closeModal(),
    });
  } else {
    form.post('/admin/users', {
      preserveScroll: true,
      onSuccess: () => closeModal(),
    });
  }
}

function confirmDelete(user) {
  userToDelete.value = user;
}

function deleteUser() {
  if (!userToDelete.value) return;
  router.delete(`/admin/users/${userToDelete.value.id}`, {
    preserveScroll: true,
    onSuccess: () => {
      userToDelete.value = null;
    },
  });
}
</script>

