<template>
  <Head>
    <title>{{ fullTitle }}</title>
    <meta name="description" :content="description" />
    <meta name="robots" content="index, follow" />

    <!-- OpenGraph / Facebook -->
    <meta property="og:type" :content="type" />
    <meta property="og:title" :content="fullTitle" />
    <meta property="og:description" :content="description" />
    <meta property="og:image" :content="computedImage" />
    <meta property="og:site_name" content="SoftPolli" />

    <!-- Twitter / X -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" :content="fullTitle" />
    <meta name="twitter:description" :content="description" />
    <meta name="twitter:image" :content="computedImage" />
  </Head>
</template>

<script setup>
import { computed } from 'vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
  title: {
    type: String,
    required: true,
  },
  description: {
    type: String,
    default: 'SoftPolli delivers world-class software engineering, cloud architecture, and digital transformation systems for modern enterprises.',
  },
  image: {
    type: String,
    default: '/images/SP-logo.png',
  },
  type: {
    type: String,
    default: 'website',
  },
});

const fullTitle = computed(() => {
  return `${props.title} | SoftPolli`;
});

const computedImage = computed(() => {
  if (props.image && props.image.startsWith('http')) {
    return props.image;
  }
  if (typeof window !== 'undefined') {
    return `${window.location.origin}${props.image.startsWith('/') ? '' : '/'}${props.image}`;
  }
  return props.image;
});
</script>
