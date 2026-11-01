<template>
  <div class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden focus-within:border-brand transition shadow-sm">
    <!-- Toolbar -->
    <div
      v-if="editor"
      class="bg-slate-100/80 dark:bg-slate-900/80 border-b border-slate-200 dark:border-slate-800 p-1.5 flex flex-wrap items-center gap-1"
    >
      <!-- Bold -->
      <button
        type="button"
        @click="editor.chain().focus().toggleBold().run()"
        :class="[
          'w-7 h-7 rounded-lg text-xs font-bold transition grid place-items-center',
          editor.isActive('bold')
            ? 'bg-brand text-white shadow-xs'
            : 'text-slate-600 dark:text-slate-300 hover:bg-slate-200/80 dark:hover:bg-slate-800',
        ]"
        title="Bold (Ctrl+B)"
      >
        <i class="fa-solid fa-bold text-[11px]"></i>
      </button>

      <!-- Italic -->
      <button
        type="button"
        @click="editor.chain().focus().toggleItalic().run()"
        :class="[
          'w-7 h-7 rounded-lg text-xs transition grid place-items-center',
          editor.isActive('italic')
            ? 'bg-brand text-white shadow-xs'
            : 'text-slate-600 dark:text-slate-300 hover:bg-slate-200/80 dark:hover:bg-slate-800',
        ]"
        title="Italic (Ctrl+I)"
      >
        <i class="fa-solid fa-italic text-[11px]"></i>
      </button>

      <!-- Strike -->
      <button
        type="button"
        @click="editor.chain().focus().toggleStrike().run()"
        :class="[
          'w-7 h-7 rounded-lg text-xs transition grid place-items-center',
          editor.isActive('strike')
            ? 'bg-brand text-white shadow-xs'
            : 'text-slate-600 dark:text-slate-300 hover:bg-slate-200/80 dark:hover:bg-slate-800',
        ]"
        title="Strikethrough"
      >
        <i class="fa-solid fa-strikethrough text-[11px]"></i>
      </button>

      <span class="w-[1px] h-4 bg-slate-300 dark:bg-slate-700 mx-1"></span>

      <!-- Heading 2 -->
      <button
        type="button"
        @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
        :class="[
          'px-2 h-7 rounded-lg text-[11px] font-bold transition flex items-center gap-1',
          editor.isActive('heading', { level: 2 })
            ? 'bg-brand text-white shadow-xs'
            : 'text-slate-600 dark:text-slate-300 hover:bg-slate-200/80 dark:hover:bg-slate-800',
        ]"
        title="Heading 2"
      >
        H2
      </button>

      <!-- Heading 3 -->
      <button
        type="button"
        @click="editor.chain().focus().toggleHeading({ level: 3 }).run()"
        :class="[
          'px-2 h-7 rounded-lg text-[11px] font-bold transition flex items-center gap-1',
          editor.isActive('heading', { level: 3 })
            ? 'bg-brand text-white shadow-xs'
            : 'text-slate-600 dark:text-slate-300 hover:bg-slate-200/80 dark:hover:bg-slate-800',
        ]"
        title="Heading 3"
      >
        H3
      </button>

      <span class="w-[1px] h-4 bg-slate-300 dark:bg-slate-700 mx-1"></span>

      <!-- Bullet List -->
      <button
        type="button"
        @click="editor.chain().focus().toggleBulletList().run()"
        :class="[
          'w-7 h-7 rounded-lg text-xs transition grid place-items-center',
          editor.isActive('bulletList')
            ? 'bg-brand text-white shadow-xs'
            : 'text-slate-600 dark:text-slate-300 hover:bg-slate-200/80 dark:hover:bg-slate-800',
        ]"
        title="Bullet List"
      >
        <i class="fa-solid fa-list-ul text-[11px]"></i>
      </button>

      <!-- Ordered List -->
      <button
        type="button"
        @click="editor.chain().focus().toggleOrderedList().run()"
        :class="[
          'w-7 h-7 rounded-lg text-xs transition grid place-items-center',
          editor.isActive('orderedList')
            ? 'bg-brand text-white shadow-xs'
            : 'text-slate-600 dark:text-slate-300 hover:bg-slate-200/80 dark:hover:bg-slate-800',
        ]"
        title="Numbered List"
      >
        <i class="fa-solid fa-list-ol text-[11px]"></i>
      </button>

      <!-- Blockquote -->
      <button
        type="button"
        @click="editor.chain().focus().toggleBlockquote().run()"
        :class="[
          'w-7 h-7 rounded-lg text-xs transition grid place-items-center',
          editor.isActive('blockquote')
            ? 'bg-brand text-white shadow-xs'
            : 'text-slate-600 dark:text-slate-300 hover:bg-slate-200/80 dark:hover:bg-slate-800',
        ]"
        title="Blockquote"
      >
        <i class="fa-solid fa-quote-left text-[11px]"></i>
      </button>

      <!-- Code block -->
      <button
        type="button"
        @click="editor.chain().focus().toggleCodeBlock().run()"
        :class="[
          'w-7 h-7 rounded-lg text-xs transition grid place-items-center',
          editor.isActive('codeBlock')
            ? 'bg-brand text-white shadow-xs'
            : 'text-slate-600 dark:text-slate-300 hover:bg-slate-200/80 dark:hover:bg-slate-800',
        ]"
        title="Code Block"
      >
        <i class="fa-solid fa-code text-[11px]"></i>
      </button>

      <span class="w-[1px] h-4 bg-slate-300 dark:bg-slate-700 mx-1"></span>

      <!-- Undo -->
      <button
        type="button"
        @click="editor.chain().focus().undo().run()"
        :disabled="!editor.can().undo()"
        class="w-7 h-7 rounded-lg text-xs text-slate-600 dark:text-slate-400 hover:bg-slate-200/80 dark:hover:bg-slate-800 disabled:opacity-30 disabled:cursor-not-allowed grid place-items-center transition"
        title="Undo"
      >
        <i class="fa-solid fa-rotate-left text-[11px]"></i>
      </button>

      <!-- Redo -->
      <button
        type="button"
        @click="editor.chain().focus().redo().run()"
        :disabled="!editor.can().redo()"
        class="w-7 h-7 rounded-lg text-xs text-slate-600 dark:text-slate-400 hover:bg-slate-200/80 dark:hover:bg-slate-800 disabled:opacity-30 disabled:cursor-not-allowed grid place-items-center transition"
        title="Redo"
      >
        <i class="fa-solid fa-rotate-right text-[11px]"></i>
      </button>
    </div>

    <!-- Editor Content Area -->
    <EditorContent
      :editor="editor"
      class="prose prose-sm max-w-none p-3.5 min-h-[140px] text-xs text-slate-900 dark:text-slate-100 focus:outline-none dark:prose-invert [&_.tiptap]:outline-none [&_.tiptap]:min-h-[120px] [&_p]:my-1.5 [&_ul]:list-disc [&_ul]:ml-4 [&_ol]:list-decimal [&_ol]:ml-4 [&_blockquote]:border-l-2 [&_blockquote]:border-brand [&_blockquote]:pl-3 [&_blockquote]:italic [&_blockquote]:text-slate-500 [&_pre]:bg-slate-900 [&_pre]:text-slate-100 [&_pre]:p-2.5 [&_pre]:rounded-xl"
    />
  </div>
</template>

<script setup>
import { onBeforeUnmount, watch } from 'vue';
import { useEditor, EditorContent } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';

const props = defineProps({
  modelValue: {
    type: String,
    default: '',
  },
  placeholder: {
    type: String,
    default: 'Write detailed description...',
  },
});

const emit = defineEmits(['update:modelValue']);

const editor = useEditor({
  content: props.modelValue,
  extensions: [StarterKit],
  editorProps: {
    attributes: {
      class: 'focus:outline-none',
    },
  },
  onUpdate: () => {
    emit('update:modelValue', editor.value?.getHTML() || '');
  },
});

watch(
  () => props.modelValue,
  (val) => {
    const isSame = editor.value?.getHTML() === val;
    if (!isSame && editor.value) {
      editor.value.commands.setContent(val || '', false);
    }
  }
);

onBeforeUnmount(() => {
  editor.value?.destroy();
});
</script>
