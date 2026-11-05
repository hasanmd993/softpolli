<template>
  <div v-if="isEnabled" class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 z-40 select-none font-sans">
    <!-- Expandable Chat Popup Window -->
    <transition
      enter-active-class="transform transition duration-300 ease-out"
      enter-from-class="opacity-0 translate-y-4 scale-95"
      enter-to-class="opacity-100 translate-y-0 scale-100"
      leave-active-class="transform transition duration-200 ease-in"
      leave-from-class="opacity-100 translate-y-0 scale-100"
      leave-to-class="opacity-0 translate-y-4 scale-95"
    >
      <div
        v-if="isOpen"
        class="mb-3 sm:mb-4 w-[calc(100vw-32px)] sm:w-[380px] max-w-[380px] bg-white rounded-3xl shadow-2xl border border-slate-200/80 overflow-hidden text-slate-800"
      >
        <!-- WhatsApp Header -->
        <div class="bg-[#075E54] text-white p-4 flex items-center justify-between">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-white/20 grid place-items-center text-white text-lg shrink-0">
              <i class="fa-brands fa-whatsapp"></i>
            </div>
            <div>
              <h4 class="font-bold text-xs text-white leading-tight">
                {{ agentName }}
              </h4>
              <p class="text-[10px] text-emerald-200 flex items-center gap-1.5 mt-0.5">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                Typically replies in minutes
              </p>
            </div>
          </div>
          <button
            @click="isOpen = false"
            class="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 text-white/80 hover:text-white transition grid place-items-center text-xs"
            aria-label="Close chat"
          >
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>

        <!-- Chat Conversation Area with Pattern BG -->
        <div class="p-4 bg-[#EFEAE2] min-h-[160px] max-h-[300px] overflow-y-auto space-y-3">
          <!-- SoftPolli Welcome Bubble -->
          <div class="flex items-start gap-2">
            <div class="bg-white p-3 rounded-2xl rounded-tl-none shadow-sm text-xs text-slate-700 max-w-[88%] leading-relaxed border border-slate-100 relative">
              <p class="font-medium mb-1">{{ welcomeMessage }}</p>
              <span class="text-[9px] text-slate-400 block text-right mt-1">Just now</span>
            </div>
          </div>

          <!-- Quick Topic Suggestion Chips -->
          <div class="pt-1">
            <p class="text-[10px] uppercase font-bold text-slate-500 tracking-wider mb-2">
              Select an inquiry topic:
            </p>
            <div class="flex flex-col gap-1.5">
              <button
                v-for="chip in quickChips"
                :key="chip"
                type="button"
                @click="selectChip(chip)"
                class="text-left text-[11px] font-medium bg-white/80 hover:bg-white text-slate-700 hover:text-emerald-700 py-1.5 px-3 rounded-xl border border-slate-200/60 shadow-xs transition transform hover:translate-x-1"
              >
                {{ chip }}
              </button>
            </div>
          </div>
        </div>

        <!-- Message Compose & Send Form -->
        <div class="p-3 bg-white border-t border-slate-100 flex items-center gap-2">
          <input
            v-model="userMessage"
            type="text"
            placeholder="Type your message..."
            class="flex-1 bg-slate-100 border border-transparent focus:border-emerald-500 focus:bg-white rounded-full px-4 py-2 text-xs text-slate-800 placeholder-slate-400 focus:outline-none transition shadow-inner"
            @keyup.enter="startWhatsAppChat"
          />
          <button
            @click="startWhatsAppChat"
            class="w-9 h-9 rounded-full bg-[#25D366] hover:bg-[#20ba5a] text-white transition grid place-items-center text-sm shadow-md shadow-emerald-500/25 shrink-0"
            aria-label="Send via WhatsApp"
            title="Send on WhatsApp"
          >
            <i class="fa-solid fa-paper-plane text-xs"></i>
          </button>
        </div>
      </div>
    </transition>

    <!-- Floating Trigger Button -->
    <div class="flex items-center gap-3 justify-end">

      <!-- Main Round Floating Button -->
      <button
        @click="toggleChat"
        class="relative w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-[#25D366] hover:bg-[#20ba5a] text-white transition-all duration-300 grid place-items-center text-xl sm:text-2xl shadow-xl shadow-emerald-600/30 transform hover:scale-105 active:scale-95"
        :aria-label="isOpen ? 'Close WhatsApp Chat' : 'Open WhatsApp Chat'"
      >
        <i :class="isOpen ? 'fa-solid fa-xmark text-xl' : 'fa-brands fa-whatsapp text-2xl'"></i>

        <!-- Green pulse ring indicator when closed -->
        <span v-if="!isOpen" class="absolute -top-0.5 -right-0.5 flex h-4 w-4">
          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
          <span class="relative inline-flex rounded-full h-4 w-4 bg-emerald-500 border-2 border-white"></span>
        </span>
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();

const isOpen = ref(false);
const showPill = ref(true);

const settings = computed(() => page.props.settings || {});

const isEnabled = computed(() => {
  const val = settings.value.whatsapp_enabled;
  return val === '1' || val === true || val === 1 || val === undefined;
});

const whatsappNumber = computed(() => {
  return settings.value.whatsapp_number || '8801700000000';
});

const agentName = computed(() => {
  return settings.value.whatsapp_agent_name || 'SoftPolli Solutions Team';
});

const welcomeMessage = computed(() => {
  return settings.value.whatsapp_welcome_message || 'Hello! How can we assist with your software project today?';
});

const defaultMessage = computed(() => {
  return settings.value.whatsapp_default_message || 'Hello SoftPolli team, I am interested in discussing a software project.';
});

const userMessage = ref(defaultMessage.value);

const quickChips = [
  '💡 I need a custom software project quote',
  '🌐 Inquiring about web application engineering',
  '📱 Inquiring about mobile app / POS development',
];

const selectChip = (chipText) => {
  userMessage.value = chipText;
  startWhatsAppChat();
};

const toggleChat = () => {
  isOpen.value = !isOpen.value;
  if (isOpen.value && !userMessage.value) {
    userMessage.value = defaultMessage.value;
  }
};

const startWhatsAppChat = () => {
  const cleanNumber = whatsappNumber.value.replace(/[^0-9]/g, '');
  const encodedText = encodeURIComponent(userMessage.value || defaultMessage.value);
  const url = `https://wa.me/${cleanNumber}?text=${encodedText}`;
  window.open(url, '_blank', 'noopener,noreferrer');
  isOpen.value = false;
};
</script>

