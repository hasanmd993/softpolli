<template>
  <div class="bg-navy-900 text-white rounded-3xl p-8 sm:p-12 shadow-2xl border border-slate-800">
    <div class="mb-6">
      <span class="text-xs font-bold text-brand uppercase tracking-widest">Get In Touch</span>
      <h3 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">Feel free to contact us</h3>
      <p class="text-xs text-slate-400 mt-2 leading-relaxed">
        Have a question or looking to consult our software engineering team? Send us a message and we'll reply today.
      </p>
    </div>

    <div v-if="submitted" class="p-6 rounded-2xl bg-brand/10 border border-brand/30 text-center">
      <div class="w-12 h-12 bg-brand text-white rounded-full grid place-items-center mx-auto mb-3 text-lg">
        <i class="fa-solid fa-check"></i>
      </div>
      <h4 class="text-base font-bold text-white mb-1">Message Sent!</h4>
      <p class="text-xs text-slate-300">Thank you for contacting SoftPolli. We will respond promptly.</p>
    </div>

    <form v-else @submit.prevent="submit" class="space-y-4 text-xs">
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <input
            v-model="form.name"
            type="text"
            placeholder="Name*"
            required
            class="w-full bg-navy-800 border border-slate-700 rounded-xl px-4 py-3.5 text-white placeholder-slate-400 focus:outline-none focus:border-brand transition"
          />
          <div v-if="form.errors.name" class="text-red-400 text-[11px] mt-1">{{ form.errors.name }}</div>
        </div>

        <div>
          <input
            v-model="form.phone"
            type="tel"
            placeholder="Phone Number"
            class="w-full bg-navy-800 border border-slate-700 rounded-xl px-4 py-3.5 text-white placeholder-slate-400 focus:outline-none focus:border-brand transition"
          />
        </div>
      </div>

      <div>
        <input
          v-model="form.email"
          type="email"
          placeholder="E-Mail Address*"
          required
          class="w-full bg-navy-800 border border-slate-700 rounded-xl px-4 py-3.5 text-white placeholder-slate-400 focus:outline-none focus:border-brand transition"
        />
        <div v-if="form.errors.email" class="text-red-400 text-[11px] mt-1">{{ form.errors.email }}</div>
      </div>

      <div>
        <select
          v-model="form.subject"
          class="w-full bg-navy-800 border border-slate-700 rounded-xl px-4 py-3.5 text-slate-300 focus:outline-none focus:border-brand transition"
        >
          <option value="Custom Software Development">Custom Software Development</option>
          <option value="ERP / CRM Solution">ERP / CRM Solution</option>
          <option value="E-Commerce & POS System">E-Commerce & POS System</option>
          <option value="Web & Mobile Application">Web & Mobile Application</option>
          <option value="Cyber Security Audit">Cyber Security Audit</option>
          <option value="General Consultation">General Consultation</option>
        </select>
      </div>

      <div>
        <textarea
          v-model="form.message"
          rows="4"
          placeholder="How can we help your business?*"
          required
          class="w-full bg-navy-800 border border-slate-700 rounded-xl px-4 py-3.5 text-white placeholder-slate-400 focus:outline-none focus:border-brand transition"
        ></textarea>
        <div v-if="form.errors.message" class="text-red-400 text-[11px] mt-1">{{ form.errors.message }}</div>
      </div>

      <button
        type="submit"
        :disabled="form.processing"
        class="w-full py-4 bg-brand hover:bg-brand-light text-white font-bold rounded-xl text-xs uppercase tracking-wider transition shadow-lg shadow-brand/25 disabled:opacity-50"
      >
        <span v-if="form.processing"><i class="fa-solid fa-circle-notch fa-spin mr-1"></i> Sending...</span>
        <span v-else>Send Message <i class="fa-solid fa-arrow-right ml-1"></i></span>
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';

const page = usePage();
const submitted = ref(false);

const form = useForm({
  _token: page.props.csrf_token || '',
  name: '',
  phone: '',
  email: '',
  subject: 'Custom Software Development',
  message: '',
});

function submit() {
  if (page.props.csrf_token) {
    form._token = page.props.csrf_token;
  }
  form.post('/contact', {
    preserveScroll: true,
    onSuccess: () => {
      submitted.value = true;
      form.reset();
    },
  });
}
</script>
