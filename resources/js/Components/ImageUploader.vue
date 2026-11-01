<template>
  <div class="w-full">
    <!-- Existing / Uploaded Image Preview -->
    <div
      v-if="modelValue"
      class="relative group rounded-2xl overflow-hidden border border-slate-200 bg-slate-50 dark:border-slate-700 dark:bg-slate-900/60 p-2.5 flex items-center gap-4 transition"
    >
      <img
        :src="modelValue"
        alt="Uploaded Preview"
        class="w-20 h-20 object-cover rounded-xl bg-white border border-slate-200 dark:bg-slate-950 dark:border-slate-800 shadow-sm"
      />
      <div class="flex-1 min-w-0 pr-2">
        <p class="text-xs font-bold text-slate-800 dark:text-white truncate">{{ modelValue.split('/').pop() }}</p>
        <div class="mt-2 flex items-center gap-2">
          <button
            type="button"
            @click="triggerFileInput"
            class="text-[11px] font-bold text-slate-700 hover:text-slate-900 bg-slate-200/80 hover:bg-slate-200 dark:text-slate-300 dark:hover:text-white dark:bg-slate-800 dark:hover:bg-slate-700 px-2.5 py-1 rounded-lg transition"
          >
            Change
          </button>
          <button
            type="button"
            @click="removeImage"
            class="text-[11px] font-bold text-rose-600 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 dark:text-rose-400 dark:hover:text-rose-300 dark:bg-rose-500/10 dark:hover:bg-rose-500/20 px-2.5 py-1 rounded-lg transition"
          >
            Remove
          </button>
        </div>
      </div>
    </div>

    <!-- Drag & Drop Upload Zone -->
    <div
      v-else
      @dragover.prevent="isDragging = true"
      @dragleave.prevent="isDragging = false"
      @drop.prevent="handleDrop"
      @click="triggerFileInput"
      class="border-2 border-dashed rounded-2xl p-6 text-center cursor-pointer transition flex flex-col items-center justify-center gap-2"
      :class="isDragging 
        ? 'border-brand bg-brand/5 dark:bg-brand/10' 
        : 'border-slate-300 hover:border-slate-400 bg-slate-50/70 hover:bg-slate-100/70 dark:border-slate-700/80 dark:hover:border-slate-500 dark:bg-slate-900/40 dark:hover:bg-slate-900/70'"
    >
      <div
        v-if="uploading"
        class="w-10 h-10 rounded-2xl bg-brand/10 text-brand grid place-items-center animate-spin text-base"
      >
        <i class="fa-solid fa-circle-notch"></i>
      </div>
      <div
        v-else
        class="w-10 h-10 rounded-2xl bg-slate-200/70 text-slate-500 dark:bg-slate-800 dark:text-slate-400 grid place-items-center text-base transition"
        :class="isDragging ? 'text-brand bg-brand/10 dark:bg-brand/20' : ''"
      >
        <i class="fa-solid fa-cloud-arrow-up"></i>
      </div>

      <div>
        <p class="text-xs font-bold text-slate-800 dark:text-white">
          <span v-if="uploading">Converting & Uploading WebP...</span>
          <span v-else>Click to upload or drag & drop</span>
        </p>
        <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-0.5">PNG, JPG, WEBP, GIF up to 5MB</p>
      </div>
    </div>

    <!-- Hidden Native File Input -->
    <input
      ref="fileInput"
      type="file"
      accept="image/*"
      class="hidden"
      @change="handleFileChange"
    />

    <!-- Upload Error Message -->
    <p v-if="errorMessage" class="text-xs text-rose-500 dark:text-rose-400 mt-1.5 font-medium flex items-center gap-1">
      <i class="fa-solid fa-triangle-exclamation"></i> {{ errorMessage }}
    </p>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { toast } from 'vue-sonner';

const props = defineProps({
  modelValue: {
    type: String,
    default: '',
  },
});

const emit = defineEmits(['update:modelValue']);

const fileInput = ref(null);
const isDragging = ref(false);
const uploading = ref(false);
const errorMessage = ref('');

function triggerFileInput() {
  fileInput.value?.click();
}

function handleFileChange(event) {
  const file = event.target.files?.[0];
  if (file) {
    uploadFile(file);
  }
}

function handleDrop(event) {
  isDragging.value = false;
  const file = event.dataTransfer?.files?.[0];
  if (file) {
    uploadFile(file);
  }
}

async function uploadFile(file) {
  errorMessage.value = '';

  if (!file.type.startsWith('image/')) {
    errorMessage.value = 'Please select a valid image file (PNG, JPG, WEBP, GIF).';
    toast.error(errorMessage.value);
    return;
  }

  if (file.size > 5 * 1024 * 1024) {
    errorMessage.value = 'Image size must be 5MB or less.';
    toast.error(errorMessage.value);
    return;
  }

  uploading.value = true;
  const formData = new FormData();
  formData.append('file', file);

  try {
    const response = await axios.post('/admin/media/upload', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    });

    emit('update:modelValue', response.data.url);
    toast.success('Image uploaded and optimized to WebP successfully!');
  } catch (error) {
    const msg = error.response?.data?.message || 'Failed to upload image. Please try again.';
    errorMessage.value = msg;
    toast.error(msg);
  } finally {
    uploading.value = false;
    if (fileInput.value) {
      fileInput.value.value = '';
    }
  }
}

function removeImage() {
  emit('update:modelValue', '');
  errorMessage.value = '';
}
</script>
