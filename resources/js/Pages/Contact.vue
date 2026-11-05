<template>
  <MainLayout>
    <Head title="Contact SoftPolli & Request Project Proposal" />

    <!-- ============ CONTACT HERO ============ -->
    <section class="bg-navy-950 text-white py-20 relative overflow-hidden">
      <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6 relative z-10 text-center">
        <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-brand/20 border border-brand/40 text-brand-light text-xs font-bold uppercase tracking-wider mb-5">
          <i class="fa-solid fa-comments"></i> Start A Conversation
        </span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-white leading-tight mb-6 max-w-3xl mx-auto">
          Let's Discuss Your <span class="text-brand">Software Vision</span>
        </h1>
        <p class="text-slate-300 text-xs sm:text-sm leading-relaxed max-w-xl mx-auto">
          Send us a message below for a direct consultation, or drop by our engineering office in Shyamoli, Dhaka.
        </p>
      </div>
    </section>

    <!-- ============ CONTACT FORM & INFO ============ -->
    <section class="py-24 bg-slate-50">
      <div class="max-w-[92%] xl:max-w-[85%] mx-auto px-6">
        <div class="grid lg:grid-cols-12 gap-12">
          <!-- Quick Contact Form -->
          <div class="lg:col-span-8">
            <QuickContactForm />
          </div>

          <!-- Direct Contact Cards -->
          <div class="lg:col-span-4 space-y-6">
            <!-- Office Card -->
            <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-md">
              <div class="w-12 h-12 rounded-2xl bg-brand/10 text-brand flex items-center justify-center text-xl mb-5">
                <i class="fa-solid fa-location-dot"></i>
              </div>
              <h3 class="font-extrabold text-lg text-navy-900 mb-2">Dhaka Office</h3>
              <p class="text-xs text-slate-500 leading-relaxed mb-4">
                {{ settings.office_address || '2B/4 Ring Road, Shyamoli, Dhaka 1207, Bangladesh' }}
              </p>
              <div class="pt-4 border-t border-slate-100 text-xs text-slate-600 space-y-2">
                <div class="flex items-center gap-2.5">
                  <i class="fa-regular fa-clock text-brand"></i>
                  <span>{{ settings.business_hours || 'Sat to Thursday: 8:00 AM – 7:00 PM' }}</span>
                </div>
                <div class="flex items-center gap-2.5">
                  <i class="fa-solid fa-envelope text-brand"></i>
                  <a :href="`mailto:${settings.contact_email || 'info@softpolli.com'}`" class="hover:text-brand font-medium">{{ settings.contact_email || 'info@softpolli.com' }}</a>
                </div>
                <div class="flex items-center gap-2.5">
                  <i class="fa-solid fa-phone text-brand"></i>
                  <span class="font-medium">{{ settings.contact_phone || '+880 1700-000000' }}</span>
                </div>
              </div>
            </div>

            <!-- Quick Consultation Card -->
            <div class="bg-navy-900 text-white rounded-3xl p-8 border border-slate-800 shadow-md">
              <div class="w-12 h-12 rounded-2xl bg-brand text-white flex items-center justify-center text-xl mb-5 shadow-md shadow-brand/25">
                <i class="fa-solid fa-bolt"></i>
              </div>
              <h3 class="font-extrabold text-lg text-white mb-2">Need Rapid Turnaround?</h3>
              <p class="text-xs text-slate-300 leading-relaxed mb-6">
                Have an urgent launch deadline or an existing platform that requires immediate code remediation? Our leads are ready to review your repository today.
              </p>
              <a
                href="mailto:support@softpolli.com"
                class="inline-flex items-center justify-center w-full py-3.5 rounded-xl bg-brand hover:bg-brand-light text-white text-xs font-bold transition shadow-md shadow-brand/20"
              >
                Direct Architect Email <i class="fa-solid fa-arrow-right text-[10px] ml-1"></i>
              </a>
            </div>

            <!-- Office Image Card -->
            <div class="rounded-3xl overflow-hidden shadow-md h-52 relative border border-slate-200">
              <img src="/images/contact-team.jpg" alt="Meeting at SoftPolli" class="w-full h-full object-cover" />
              <div class="absolute inset-0 bg-gradient-to-t from-navy-950/80 via-transparent to-transparent flex items-end p-5">
                <span class="text-xs text-white font-semibold">Visitors Welcome by Appointment</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </MainLayout>
</template>

<script setup>
import { computed } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import QuickContactForm from '@/Components/QuickContactForm.vue';

const page = usePage();
const settings = computed(() => page.props.settings || {});
</script>
